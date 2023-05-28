<div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        {{ __('Add new transaction') }}
    </h1>

    <x-validation-errors class="mb-4" />

    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
        {{ session('status') }}
    </div>
    @endif

    <x-form-section submit="saveTransaction" class="">

        <x-slot name="form">
            <!-- Amount -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Amount') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="transaction.amount" autofocus />
                <x-input-error for="name" class="mt-2" />

                <x-label for="is_recurring" value="{{ __('Recurring?') }}" />
                <x-checkbox wire:model="transaction.is_recurring" :value="$transaction->is_recurring" />
                <x-input-error for="is_recurring" class="mt-2" />
                @if($transaction->is_recurring)
                <x-label for="recurring_frequency" value="{{ __('Recurring Frequency') }}" />
                <x-input id="recurring_frequency" type="text" class="mt-1 block w-full" wire:model.defer="transaction.recurring_frequency" autofocus />
                <x-input-error for="recurring_frequency" class="mt-2" />
                <x-label for="recurring_on" value="{{ __('Recurring on') }}" />
                <x-input id="recurring_on" type="text" class="mt-1 block w-full" wire:model.defer="transaction.recurring_on" autofocus />
                <x-input-error for="recurring_on" class="mt-2" />
                @endif
            </div>

            <!-- Category -->
            <div class="col-span-6">
                <x-label for="category" value="{{ __('Category') }}" />
                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($this->categories ?? [] as $category)
                    <label class="flex items-center">
                        <x-checkbox wire:model.defer="transaction.category_id" :value="$category->id" />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                    </label>

                    @endforeach
                    <button class="px-4 py-2 font-semibold text-sm bg-sky-500 text-white rounded-none shadow-sm" wire:click.prevent="$set('showCreateCategoryModal', true)" wire:loading.attr="disabled">
                        {{ __('Add new category') }}
                    </button>
                </div>
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="created">
                {{ __('Created.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>

    <!-- Create Category Modal -->
    @livewire('create-category-modal', ['showCreateCategoryModal' => $showCreateCategoryModal])

    <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="https://laravel.com/docs">Transactions of this month</a>
                </h2>
            </div>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Laravel has wonderful documentation covering every aspect of the framework. Whether you're new to the framework or have previous experience, we recommend reading all of the documentation from beginning to end.
            </p>

            <p class="mt-4 text-sm">
                <a href="https://laravel.com/docs" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                    Explore the documentation

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>

        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="https://laracasts.com">Pay this month</a>
                </h2>
            </div>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
            </p>

            <p class="mt-4 text-sm">
                <a href="https://laracasts.com" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                    Start watching Laracasts

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>
    </div>
</div>

