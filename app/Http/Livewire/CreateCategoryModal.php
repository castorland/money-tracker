<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CreateCategoryModal extends Component
{
    public bool $showCreateCategoryModal = false;
    public array $createCategoryForm = [
        'name' => '',
        'type' => '',
    ];

    protected $listeners = ['showCreateCategoryModalUpdated'];

    public function showCreateCategoryModalUpdated($showCreateCategoryModal)
    {
        $this->showCreateCategoryModal = $showCreateCategoryModal;
    }

    public function createCategory()
    {
        $this->resetErrorBag();

        Validator::make([
            'name' => $this->createCategoryForm['name'],
            'type' => $this->createCategoryForm['type'],
        ], [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createCategoryForm');

        Category::create($this->createCategoryForm);

        $this->createCategoryForm['name'] = '';
        $this->createCategoryForm['type'] = '';
        $this->showCreateCategoryModal = false;

        $this->emitUp('categoryCreated');
    }

    public function render()
    {
        return view('livewire.create-category-modal');
    }
}
