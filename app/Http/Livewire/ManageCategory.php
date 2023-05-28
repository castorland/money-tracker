<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class ManageCategory extends Component
{
    public bool $confirmingCategoryDeletion, $updatingCategory, $showCreateCategoryModal = false;
    public $categoryIdBeingDeleted;
    public $categoryBeingUpdated;

    protected $rules = [
        'categoryBeingUpdated.name' => 'required|string',
        'categoryBeingUpdated.type' => 'required|string',
    ];

    protected $listeners = ['categoryCreated'];

    public function categoryCreated()
    {
        $this->emit('created');
    }

    public function updatedShowCreateCategoryModal($showCreateCategoryModal)
    {
        $this->emit('showCreateCategoryModalUpdated', $showCreateCategoryModal);
    }

    public function manageCategory($categoryId)
    {
        $this->updatingCategory = true;

        $this->categoryBeingUpdated = $this->categories->where('id', $categoryId)->firstOrFail();
    }

    public function updateCategory()
    {
        $this->validate();

        $this->categoryBeingUpdated->save();

        $this->updatingCategory = false;
    }

    public function confirmCategoryDeletion($categoryId)
    {
        $this->confirmingCategoryDeletion = true;

        $this->categoryIdBeingDeleted = $categoryId;
    }

    public function deleteCategory()
    {
        Category::where('id', $this->categoryIdBeingDeleted)->first()->delete();

        $this->confirmingCategoryDeletion = false;

        $this->categoryIdBeingDeleted = null;
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function render()
    {
        return view('category.manage-category');
    }
}
