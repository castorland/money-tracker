<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\RecurringPayment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public bool $confirmingRecurringPaymentDeletion = false;
    public $recurringIdBeingDeleted;

    protected $listeners = ['categoryCreated'];

    public function recurringPayed($recurringId)
    {
        $recurring = RecurringPayment::find($recurringId);
        $transaction = Transaction::find($recurring->transaction_id);
        $newTransaction = $transaction->replicate();
        $newTransaction->transaction_date = now();
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

    public function confirmRecurringDeletion($recurringId)
    {
        $this->confirmingRecurringPaymentDeletion = true;

        $this->recurringIdBeingDeleted = $recurringId;
    }

    public function deleteRecurringPayment()
    {
        RecurringPayment::where('id', $this->recurringIdBeingDeleted)->first()->delete();

        $this->confirmingRecurringPaymentDeletion = false;

        $this->recurringIdBeingDeleted = null;
    }

    public function categoryCreated()
    {
        $this->emit('created');
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

    public function getTransactionsProperty()
    {
        return Transaction::with('category')->orderBy('transaction_date', 'DESC')->latest()->limit(10)->get();
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('dashboard.dashboard');
    }
}
