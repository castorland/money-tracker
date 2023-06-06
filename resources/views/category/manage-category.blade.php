<div class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

    <div class="flex justify-between mt-8">
        <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
            {{ __('Categories') }}
        </h1>

        <button class="px-4 py-2 text-sm font-semibold text-white rounded-none shadow-sm bg-sky-500" wire:click.prevent="$set('showCreateCategoryModal', true)" wire:loading.attr="disabled">
            {{ __('Add new category') }}
        </button>
    </div>

    <x-validation-errors class="mb-4" />

    @if (session('status'))
    <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
        {{ session('status') }}
    </div>
    @endif

    <x-section-border />

    <!-- Manage Categories -->
    <div class="mt-10 sm:mt-0">
        <x-action-section class="md:grid-cols-2">

            <!-- Category List -->
            <x-slot name="content">
                <div class="space-y-6">
                    @forelse ($this->categories as $category)
                    <div class="flex items-center justify-between">
                        <div class="break-all dark:text-white">
                            {{ $category->name }}
                        </div>

                        <div class="flex items-center ml-2">
                            <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                {{ $category->type }}
                            </div>

                            <x-secondary-button class="ml-6" wire:click="manageCategory({{ $category->id }})">{{ __('Edit') }}</x-secondary-button>
                            <x-danger-button class="ml-6" wire:click="confirmCategoryDeletion({{ $category->id }})">{{ __('Delete') }}</x-danger-button>
                        </div>
                    </div>
                    @empty
                    <div class="flex items-center justify-between">
                        <div class="break-all dark:text-white">
                            {{ __('There is no category yet.') }}
                        </div>
                    </div>
                    @endforelse
                </div>
            </x-slot>
        </x-action-section>
    </div>

    <!-- Edit Category Modal -->
    <x-dialog-modal wire:model="updatingCategory">
        <x-slot name="title">
            Update {{ $categoryBeingUpdated?->name }} Category
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-label for="categoryName" value="{{ __('Category Name') }}" />
                <x-input id="categoryName" type="text" class="block w-full mt-1" wire:model.defer="categoryBeingUpdated.name" autofocus />
                <x-input-error for="categoryName" class="mt-2" />
                <x-label for="categoryType" value="{{ __('Category Type') }}" />
                <select id="categoryType" wire:model="categoryBeingUpdated.type">
                    <option>{{ __('Choose a type') }}</option>
                    @foreach (\App\Models\Category::getCategoryTypes() as $value => $title)
                    <option value="{{$value}}" @if($categoryBeingUpdated?->type === $value) selected @endif>{{$title}}</option>
                    @endforeach
                </select>
                <x-input-error for="categoryType" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('updatingCategory', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="updateCategory" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Token Confirmation Modal -->
    <x-confirmation-modal wire:model="confirmingCategoryDeletion">
        <x-slot name="title">
            {{ __('Delete Category') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this category?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingCategoryDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteCategory" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Create Category Modal -->
    @livewire('create-category-modal', ['showCreateCategoryModal' => $showCreateCategoryModal])
</div>