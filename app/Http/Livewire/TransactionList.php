<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;

    protected $transactions;

    public function mount()
    {
        $this->transactions = Transaction::with('category')->paginate(25);
    }

    public function render()
    {
        return view('transaction.transaction-list', ['transactions' => $this->transactions]);
    }
}
