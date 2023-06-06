<div class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        {{ __('Add new transaction') }}
    </h1>

    <x-validation-errors class="mb-4" />

    {{-- <x-banner /> --}}

    @if (session('status'))
    <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
        {{ session('status') }}
    </div>
    @endif

    <x-form-section submit="saveTransaction" class="md:grid-cols-2">

        <x-slot name="form">
            <!-- Amount -->
            <div class="col-span-6 md:col-span-1">
                <x-label for="name" value="{{ __('Amount') }}" class="font-semibold" />
                <x-input id="name" type="number" class="block w-full mt-1" wire:model.defer="transaction.amount" autofocus />
                <x-input-error for="name" class="mt-2" />
            {{-- </div> --}}
            {{-- <div class="col-span-6 sm:col-span-1"> --}}
                <x-label for="is_recurring" value="{{ __('Recurring?') }}" class="font-semibold" />
                <x-checkbox wire:model="transaction.is_recurring" :value="$transaction->is_recurring ?? false" />
                <x-input-error for="is_recurring" class="mt-2" />
            </div>
            <div class="col-span-6 md:col-span-1">
                <x-label for="transaction_date" value="{{ __('Transaction Date') }}" class="font-semibold" />
                <x-input id="transaction_date" type="date" class="block w-full mt-1" wire:model.defer="transaction.transaction_date" />
                <x-input-error for="transaction_date" class="mt-2" />
            </div>
            <div class="col-span-6 md:col-span-1">
                <x-label for="note" value="{{ __('Note') }}" class="font-semibold" />
                <x-input id="note" type="text" class="block w-full mt-1" wire:model.defer="transaction.note" />
                <x-input-error for="note" class="mt-2" />
            </div>
            <div class="col-span-6 md:col-span-1">
                @if($transaction->is_recurring)
                <x-label for="recurring_frequency" value="{{ __('Recurring') }}" class="font-semibold" />
                <div class="flex content-between mt-1">
                    <select class="w-2/5 " wire:model.defer="transaction.recurring_frequency">
                        <option>{{ __('Choose frequency') }}</option>
                    @foreach (range(1, 30) as $number)
                        <option value="{{ $number }}">{{ $number }}</option>
                    @endforeach
                    </select>
                    <x-input-error for="recurring_frequency" class="mt-2" />
                    <select class="w-3/5 " wire:model.defer="transaction.recurring_period">
                        <option>{{ __('Choose period') }}</option>
                        <option value="day">{{ __('Day') }}</option>
                        <option value="week">{{ __('Week') }}</option>
                        <option value="month">{{ __('Month') }}</option>
                        <option value="year">{{ __('Year') }}</option>
                    </select>
                    <x-input-error for="recurring_period" class="mt-2" />
                </div>
                <x-label for="recurring_on" value="{{ __('Recurring on') }}" class="font-semibold" />
                <x-input id="recurring_on" type="date" class="block w-full mt-1" wire:model.defer="transaction.recurring_on" autofocus />
                <x-input-error for="recurring_on" class="mt-2" />
                @endif
            </div>

            <!-- Category -->
            <div class="col-span-6 md:col-span-1">
                <x-label for="" value="{{ __('Category') }}" class="font-semibold" />
                <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                    @forelse ($this->categories ?? [] as $category)
                    <label class="flex items-center">
                        <x-radio wire:model="transaction.category_id" :value="$category->id" />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                    </label>
                    @empty
                    <div class="flex items-center justify-between">
                        <div class="break-all dark:text-white">
                            {{ __('There is no category yet.') }}
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="col-span-6 md:col-span-1">
                <x-primary-button wire:click.prevent="$set('showCreateCategoryModal', true)" wire:loading.attr="disabled">{{ __('Add new category') }}</x-primary-button>
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

    <div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="https://laravel.com/docs">{{ __('Transactions of this month') }}</a>
                </h2>
            </div>

            <div class="mt-10 sm:mt-3">
                <x-action-section class="md:grid-cols-2">

                    <!-- Transactions of the month -->
                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse ($this->transactions as $transaction)
                            <div class="flex items-center justify-between">
                                <div class="break-all dark:text-white">
                                    {{ $transaction->category->name }}
                                </div>

                                <div class="flex items-center ml-2">
                                    <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                        {{ $transaction->transaction_date->format('Y-m-d') }}
                                    </div>
                                    <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                        {{ \App\Models\Category::getCategoryTypes($transaction->category->type) }}
                                    </div>

                                    {{-- <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                        {{ $transaction->is_recurring ? __('Recurring') : '' }}
                                    </div> --}}

                                    <div class="font-semibold dark:text-white md:mr-12 sm:mr-4">
                                        {{ $transaction->amount }}
                                    </div>

                                </div>
                            </div>
                            @empty
                            <div class="flex items-center justify-between">
                                <div class="break-all dark:text-white">
                                    {{ __('There is no transcation in this month yet.') }}
                                </div>
                            </div>
                            @endforelse

                        </div>
                    </x-slot>
                </x-action-section>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-green-400 shadow sm:p-6 dark:bg-gray-800 sm:rounded-lg">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="break-all dark:text-white">
                                    {{ __('Balance') }}
                                </div>
                                <div class="flex items-center ml-2">
                                    <div class="font-semibold dark:text-white md:mr-12 sm:mr-4">
                                        {{ $this->balance }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-sm">
                <a href="https://laravel.com/docs" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                    {{ __('All transactions') }}

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-5 h-5 ml-1 fill-indigo-500 dark:fill-indigo-200">
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
                    <a href="https://laracasts.com">{{ __('Recurring Expenses') }}</a>
                </h2>
            </div>

            <div class="mt-10 sm:mt-3">
                <x-action-section class="md:grid-cols-2">

                    <!-- Recurring Transactions List -->
                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse ($this->recurringExpenses as $transaction)
                            <div class="flex items-center justify-between">
                                <x-checkbox :value="$transaction->id" wire:click="recurringPayed({{$transaction->id}})" />
                                <div class="break-all dark:text-white">
                                    {{ $transaction->transaction->category->name }}
                                </div>

                                <div class="flex items-center ml-2">
                                    <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                        {{ $transaction->next_due->format('Y-m-d') }}
                                    </div>
                                    <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                        {{ \App\Models\Category::getCategoryTypes($transaction->transaction->category->type) }}
                                    </div>

                                    {{-- <div class="text-sm text-gray-400 md:mr-12 sm:mr-4">
                                                    {{ $transaction->is_recurring ? __('Recurring') : '' }}
                                </div> --}}

                                <div class="font-semibold dark:text-white md:mr-12 sm:mr-4">
                                    {{ $transaction->transaction->amount }}
                                </div>

                            </div>
                        </div>
                        @empty
                        <div class="flex items-center justify-between">
                            <div class="break-all dark:text-white">
                                {{ __('There is no recurring transcations yet.') }}
                            </div>
                        </div>
                        @endforelse

                        </div>
                    </x-slot>
                </x-action-section>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-gray-200 shadow sm:p-6 dark:bg-gray-400 sm:rounded-lg">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="break-all dark:text-white">
                                    {{ __('Total') }}
                                </div>
                                <div class="flex items-center ml-2">
                                    <div class="font-semibold dark:text-white md:mr-12 sm:mr-4">
                                        {{ $this->recurringTotalExpenses }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-sm">
                <a href="https://laracasts.com" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                    Start watching Laracasts

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-5 h-5 ml-1 fill-indigo-500 dark:fill-indigo-200">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>
    </div>

    <!-- Similar Transaction Confirmation Modal -->
    <x-confirmation-modal wire:model="showNewRecurringTransactionConfirmation">
        <x-slot name="title">
            {{ __('Similar Transaction Found') }}
        </x-slot>

        <x-slot name="content">
            {{ __('A transaction with same details saved at ') }} {{ $similarTransaction?->created_at->format('Y-m-d') }}.
            <br>
            {{ __('Are you sure you would like to save this transaction?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showNewRecurringTransactionConfirmation')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="saveTransaction(true)" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>

