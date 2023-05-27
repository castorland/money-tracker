<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Money;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Component
{
    public Money $money;
    public array $createCategoryForm = [
        'name' => '',
        'type' => '',
    ];
    public bool $showCreateCategoryModal = false;

    protected $rules = [
        'money.amount' => ['required', 'integer'],
        'money.category_id' => ['required', 'integer'],
    ];

    public function mount()
    {
        $this->money = new Money();
    }

    public function saveTransaction()
    {
        $this->validate();

        $this->money->save();

        $this->money = new Money();

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
