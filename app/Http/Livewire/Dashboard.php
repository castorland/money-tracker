<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public Transaction $transaction;

    public bool $showCreateCategoryModal = false;

    protected $rules = [
        'transaction.amount' => ['required', 'integer'],
        'transaction.category_id' => ['required', 'integer'],
        'transaction.is_recurring' => ['nullable', 'boolean'],
        'transaction.recurring_frequency' => ['nullable', 'integer'],
        'transaction.recurring_on' => ['nullable', 'string'],
    ];

    protected $listeners = ['categoryCreated'];

    public function mount()
    {
        $this->transaction = new Transaction();
    }

    public function saveTransaction()
    {
        $this->validate();

        $this->transaction->save();

        $this->transaction = new Transaction();

        $this->emit('created');
    }

    public function categoryCreated()
    {
        $this->emit('created');
    }

    public function updatedShowCreateCategoryModal($showCreateCategoryModal)
    {
        $this->emit('showCreateCategoryModalUpdated', $showCreateCategoryModal);
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getTransactionsProperty()
    {
        return Transaction::all();
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
