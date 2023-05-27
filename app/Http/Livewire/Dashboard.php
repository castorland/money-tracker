<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Component
{
    public Transaction $transaction;
    public array $createCategoryForm = [
        'name' => '',
        'type' => 'expenses',
    ];
    public bool $showCreateCategoryModal = false;

    protected $rules = [
        'transaction.amount' => ['required', 'integer'],
        'transaction.category_id' => ['required', 'integer'],
    ];

    public function mount()
    {
        $this->transaction = new Transaction();
    }

    public function saveTransaction()
    {
        $this->validate();

        $this->transaction->save();

        $this->transaction = new transaction();

        $this->emit('created');
    }

    public function createCategory()
    {
        $this->resetErrorBag();

        Validator::make([
            'name' => $this->createCategoryForm['name'],
        ], [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createCategoryForm');

        Category::create($this->createCategoryForm);

        $this->createCategoryForm['name'] = '';
        $this->createCategoryForm['type'] = '';

        $this->emit('created');
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
