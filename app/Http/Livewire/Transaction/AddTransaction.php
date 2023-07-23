<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;

class AddTransaction extends Component
{
    public Transaction $transaction;
    public bool $newRecurringTransactionConfirmed = false;
    public bool $showNewRecurringTransactionConfirmation = false;
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

            $this->transaction = new Transaction(['is_recurring' => false, 'transaction_date' => now()]);
            $this->showNewRecurringTransactionConfirmation = false;
            $this->emit('created');
        }
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    private function readyToSaveTransaction(): bool
    {
        return ($this->transaction->is_recurring && !$this->newRecurringTransactionConfirmed && !$this->similarTransaction) ||
            ($this->transaction->is_recurring && $this->newRecurringTransactionConfirmed) ||
            !$this->transaction->is_recurring;
    }

    public function render()
    {
        return view('transaction.add-transaction');
    }
}
