<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\RecurringPayment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public Transaction $transaction;

    public bool $showCreateCategoryModal = false;
    public bool $showNewRecurringTransactionConfirmation = false;
    public bool $newRecurringTransactionConfirmed = false;
    public $similarTransaction;

    protected $rules = [
        'transaction.amount' => ['required', 'integer', 'min:1'],
        'transaction.category_id' => ['required', 'integer'],
        'transaction.note' => ['nullable', 'string', 'max:255'],
        'transaction.transaction_date' => ['required', 'date'],
        'transaction.category_id' => ['required', 'integer'],
        'transaction.is_recurring' => ['boolean'],
        'transaction.recurring_frequency' => ['required_if:transaction.is_recurring,true'],
        'transaction.recurring_period' => ['required_if:is_recurring,true'],
        'transaction.recurring_on' => ['required_if:is_recurring,true'],
    ];

    protected $listeners = ['categoryCreated'];

    public function mount()
    {
        $this->transaction = new Transaction(['is_recurring' => false, 'transaction_date' => now()]);
    }

    public function saveTransaction($newRecurringTransactionConfirmed = false)
    {
        $this->validate();

        $this->newRecurringTransactionConfirmed = $newRecurringTransactionConfirmed;

        if ($this->transaction->is_recurring && !$this->newRecurringTransactionConfirmed) {
            $this->similarTransaction = Transaction::where([
                'amount' => $this->transaction->amount,
                'category_id' => $this->transaction->category_id,
                'note' => $this->transaction->note,
                'is_recurring' => $this->transaction->is_recurring,
                'recurring_frequency' => $this->transaction->recurring_frequency,
                'recurring_period' => $this->transaction->recurring_period,
                'recurring_on' => $this->transaction->recurring_on,
            ])->first();

            if ($this->similarTransaction) {
                $this->showNewRecurringTransactionConfirmation = true;
            }
        }

        if ($this->readyToSaveTransaction()) {
            $this->transaction->save();

            if ($this->transaction->is_recurring) {
                $this->transaction->recurring()->firstOrCreate(['next_due' => $this->transaction->next_payment]);
            }

            $this->transaction = new Transaction(['is_recurring' =>false, 'transaction_date' => now()]);
            $this->showNewRecurringTransactionConfirmation = false;
            $this->emit('created');
        }
    }

    public function recurringPayed($recurringId)
    {
        $recurring = RecurringPayment::find($recurringId);
        $transaction = Transaction::find($recurring->transaction_id);
        $newTransaction = $transaction->replicate();
        $newTransaction->save();
        $dateString = $transaction->recurring_frequency . ' ' . $transaction->recurring_period;
        $interval = \DateInterval::createFromDateString($dateString);
        $date = new \DateTime($recurring->next_due);
        $recurring->next_due = $date->add($interval)->format('Y-m-d');
        $recurring->save();

        $this->dispatchBrowserEvent('noty-message', [
            'style' => 'success',
            'message' => __('Recurring payment success! You can see it in your transactions list.')
        ]);
    }

    public function categoryCreated()
    {
        $this->emit('created');
    }

    public function updatedShowCreateCategoryModal($showCreateCategoryModal)
    {
        $this->emit('showCreateCategoryModalUpdated', $showCreateCategoryModal);
    }

    public function getRecurringExpensesProperty()
    {
        return RecurringPayment::with('transaction.category')->whereHas('transaction.category', function (Builder $query) {
            $query->where('type', 'expenses')->orWhere('type', 'loans');
        })->orderBy('next_due')->get();
    }

    public function getBalanceProperty()
    {
        $incomes = Transaction::whereHas('category', function (Builder $query) {
            $query->where('type', 'incomes');
        })->where('transaction_date', '>=', now()->startOfMonth())->sum('amount');

        $expenses = Transaction::whereHas('category', function (Builder $query) {
            $query->where('type', 'expenses')->orWhere('type', 'loans');
        })->where('transaction_date', '>=', now()->startOfMonth())->sum('amount');

        return $incomes - $expenses;
    }

    public function getRecurringTotalExpensesProperty()
    {
        $expenses = RecurringPayment::whereHas('transaction.category', function (Builder $query) {
            $query->where('type', 'expenses')->orWhere('type', 'loans');
        })
        ->join('transactions', 'recurring_payments.transaction_id', '=', 'transactions.id')
        ->where('next_due', '>=', now()->startOfMonth())
        ->sum('transactions.amount');

        return $expenses;
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getTransactionsProperty()
    {
        return Transaction::with('category')->where('created_at', '>=', now()->startOfMonth())->orderBy('transaction_date', 'ASC')->get();
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('dashboard.dashboard');
    }

    private function readyToSaveTransaction(): bool
    {
        return ($this->transaction->is_recurring && !$this->newRecurringTransactionConfirmed && !$this->similarTransaction) ||
            ($this->transaction->is_recurring && $this->newRecurringTransactionConfirmed) ||
            !$this->transaction->is_recurring;
    }
}
