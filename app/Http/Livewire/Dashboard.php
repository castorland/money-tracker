<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public Transaction $transaction;

    public bool $showCreateCategoryModal = false;

    protected $rules = [
        'transaction.amount' => ['required', 'integer', 'min:1'],
        'transaction.category_id' => ['required', 'integer'],
        'transaction.is_recurring' => ['boolean'],
        'transaction.recurring_frequency' => ['nullable', 'integer'],
        'transaction.recurring_on' => ['nullable', 'string'],
    ];

    protected $listeners = ['categoryCreated'];

    public function mount()
    {
        $this->transaction = new Transaction(['is_recurring' => false]);
    }

    public function saveTransaction()
    {
        $this->validate();

        $this->transaction->save();

        $this->transaction = new Transaction(['is_recurring' => false]);

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

    public function getBalanceProperty()
    {
        $incomes = Transaction::whereHas('category', function (Builder $query) {
            $query->where('type', 'incomes');
        })->where('created_at', '>=', now()->startOfMonth())->sum('amount');

        $expenses = Transaction::whereHas('category', function (Builder $query) {
            $query->where('type', 'expenses')->orWhere('type', 'loans');
        })->where('created_at', '>=', now()->startOfMonth())->sum('amount');

        return $incomes - $expenses;
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getTransactionsProperty()
    {
        return Transaction::with('category')->where('created_at', '>=', now()->startOfMonth())->get();
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
