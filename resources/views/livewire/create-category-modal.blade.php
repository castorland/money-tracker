<x-dialog-modal wire:model="showCreateCategoryModal">
    <x-slot name="title">
        {{ __('Add new category') }}
    </x-slot>

    <x-slot name="content">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-label for="categoryName" value="{{ __('Category Name') }}" />
            <x-input id="categoryName" type="text" class="mt-1 block w-full" wire:model.defer="createCategoryForm.name" autofocus />
            <x-input-error for="categoryName" class="mt-2" />
            <x-label for="categoryType" value="{{ __('Category Type') }}" />
            <select id="categoryType" wire:model="createCategoryForm.type">
                <option>{{ __('Choose a type') }}</option>
                @foreach (\App\Models\Category::getCategoryTypes() as $value => $title)
                <option value="{{$value}}">{{$title}}</option>
                @endforeach
            </select>
            <x-input-error for="categoryType" class="mt-2" />

        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showCreateCategoryModal', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button class="ml-3" wire:click="createCategory" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-dialog-modal>