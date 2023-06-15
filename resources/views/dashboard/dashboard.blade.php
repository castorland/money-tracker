<div
    class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

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
                <x-input id="name" type="number" class="block w-full mt-1" wire:model.defer="transaction.amount"
                    autofocus />
                <x-input-error for="name" class="mt-2" />
                {{-- </div> --}}
                {{-- <div class="col-span-6 sm:col-span-1"> --}}
                <x-label for="is_recurring" value="{{ __('Recurring?') }}" class="font-semibold" />
                <x-checkbox wire:model="transaction.is_recurring" :value="$transaction->is_recurring ?? false" />
                <x-input-error for="is_recurring" class="mt-2" />
            </div>
            <div class="col-span-6 md:col-span-1">
                <x-label for="transaction_date" value="{{ __('Transaction Date') }}" class="font-semibold" />
                <x-input id="transaction_date" type="date" class="block w-full mt-1"
                    wire:model.defer="transaction.transaction_date" />
                <x-input-error for="transaction_date" class="mt-2" />
            </div>
            <div class="col-span-6 md:col-span-1">
                <x-label for="note" value="{{ __('Note') }}" class="font-semibold" />
                <x-input id="note" type="text" class="block w-full mt-1" wire:model.defer="transaction.note" />
                <x-input-error for="note" class="mt-2" />
            </div>
            <div class="col-span-6 md:col-span-2">
                @if ($transaction->is_recurring)
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
                    <x-input id="recurring_on" type="date" class="block w-full mt-1"
                        wire:model.defer="transaction.recurring_on" autofocus />
                    <x-input-error for="recurring_on" class="mt-2" />
                @endif
            </div>

            <!-- Category -->
            <div class="col-span-6 md:col-span-5">
                <x-label for="" value="{{ __('Category') }}" class="font-semibold" />
                <div class="grid grid-cols-2 gap-4 mt-2 md:grid-cols-3">
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
                <x-primary-button wire:click.prevent="$set('showCreateCategoryModal', true)"
                    wire:loading.attr="disabled">{{ __('Add new category') }}</x-primary-button>
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

    <div class="grid grid-cols-1 gap-6 p-6 mt-10 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                </svg>

                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Last 10 Transactions') }}
                </h2>
            </div>

            <div class="mt-10 sm:mt-3">
                <x-action-section class="md:grid-cols-2">

                    <!-- Transactions of the month -->
                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse ($this->transactions as $transaction)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if (in_array($transaction->category->type, ['expenses', 'loans']))
                                            <svg class="flex items-center justify-center w-8 h-8 mb-0 mr-4 text-xs text-red-600 transition-all hover:opacity-75 stroke-red-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg class="flex items-center justify-center w-8 h-8 mb-0 mr-4 text-xs transition-all text-emerald-600 hover:opacity-75 stroke-emerald-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                        <div class="flex flex-col dark:text-white">
                                            <h6 class="mb-1 font-semibold leading-normal text-slate-700">
                                                {{ $transaction->category->name }}</h6>
                                            <span
                                                class="text-xs leading-tight">{{ $transaction->transaction_date->format('Y-m-d') }}</span>
                                            <span class="text-sm text-gray-400 break-all sm:mr-4">
                                                {{ $transaction->note }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center justify-center ml-2">
                                        <div
                                            class="font-semibold dark:text-white @if (in_array($transaction->category->type, ['expenses', 'loans'])) text-red-600 @else text-emerald-600 @endif">
                                            {{ in_array($transaction->category->type, ['expenses', 'loans']) ? '-' : '+' }}{{ number_format($transaction->amount, 0, ',', ' ') }}
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
                    <div
                        class="px-4 py-5 shadow sm:p-6 dark:bg-gray-800 sm:rounded-lg bg-opacity-50 @if ($this->balance > 0) bg-emerald-400 @else bg-red-400 @endif">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex flex-col dark:text-white">
                                        <h6 class="mb-1 font-semibold leading-normal text-slate-700">
                                            {{ __('Balance of This Month') }}</h6>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center justify-center ml-2">
                                    <div class="font-semibold dark:text-white">
                                        {{ number_format($this->balance, 0, ',', ' ') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-sm">
                <a href="{{ route('transactions.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                    {{ __('All transactions') }}

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        class="w-5 h-5 ml-1 fill-indigo-500 dark:fill-indigo-200">
                        <path fill-rule="evenodd"
                            d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>


        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>

                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Recurring Expenses') }}
                </h2>
            </div>

            <div class="mt-10 sm:mt-3">
                <x-action-section class="md:grid-cols-2">

                    <!-- Recurring transactions -->
                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse ($this->recurringExpenses as $transaction)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="flex items-center justify-center w-8 h-8 mb-0 mr-4 text-xs text-red-600 transition-all hover:opacity-75">
                                            <x-checkbox class="mr-4" :value="$transaction->id"
                                                wire:click="recurringPayed({{ $transaction->id }})" />
                                        </div>
                                        <div class="flex flex-col dark:text-white">
                                            <h6 class="mb-1 font-semibold leading-normal text-slate-700">
                                                {{ $transaction->transaction->category->name }}</h6>
                                            <span class="text-xs leading-tight">{{ __('Next due') }}:
                                                {{ $transaction->next_due->format('Y-m-d') }}
                                            </span>
                                            <span class="text-xs leading-tight">
                                                {{ $transaction->transaction->note }}
                                            </span>
                                        </div>

                                    </div>

                                    <div class="flex items-center justify-center ml-2">
                                        <div class="font-semibold dark:text-white">
                                            {{ number_format($transaction->transaction->amount, 0, ',', ' ') }}
                                        </div>
                                        <div class="flex items-center ">
                                            <button wire:click="confirmRecurringDeletion({{ $transaction->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="flex items-center justify-center w-5 h-5 mb-0 ml-2 text-xs text-red-600 transition-all hover:opacity-75 stroke-red-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
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
                    <div class="px-4 py-5 bg-opacity-50 shadow sm:p-6 dark:bg-gray-800 sm:rounded-lg bg-neutral-300">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex flex-col dark:text-white">
                                        <h6 class="mb-1 font-semibold leading-normal text-slate-700">
                                            {{ __('Total') }}</h6>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center justify-center ml-2">
                                    <div class="font-semibold dark:text-white">
                                        {{ number_format($this->recurringTotalExpenses, 0, ',', ' ') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-sm">
                <a href="#" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                    {{ __('All recurring transactions') }}

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        class="w-5 h-5 ml-1 fill-indigo-500 dark:fill-indigo-200">
                        <path fill-rule="evenodd"
                            d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>


        <!-- Similar Transaction Confirmation Modal -->
        <x-confirmation-modal wire:model="showNewRecurringTransactionConfirmation">
            <x-slot name="title">
                {{ __('Similar Transaction Found') }}
            </x-slot>

            <x-slot name="content">
                {{ __('A transaction with same details saved at ') }}
                {{ $similarTransaction?->created_at->format('Y-m-d') }}.
                <br>
                {{ __('Are you sure you would like to save this transaction?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showNewRecurringTransactionConfirmation')"
                    wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="saveTransaction(true)" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>

        <!-- Delete Recurring Payment Confirmation Modal -->
        <x-confirmation-modal wire:model="confirmingRecurringPaymentDeletion">
            <x-slot name="title">
                {{ __('Delete Recurring Payment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to delete this recurring payment?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingRecurringPaymentDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteRecurringPayment" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </div>
