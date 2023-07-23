<div>
    <form class="flex flex-wrap mt-6 -mx-3" wire:submit.prevent="saveTransaction">
        <div class="w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap -mx-3">
                        <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                            <div class="flex flex-col h-full">
                                <label for="" value="">
                                    <h5 class="pt-2 mb-6 font-bold ">{{ __('Add new transaction') }}</h5>
                                </label>
                                <x-validation-errors class="mb-4" />
                                @if (session('status'))
                                    <div class="mb-4 text-sm font-medium text-teal-600 dark:text-teal-400">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <x-label for="name" value="{{ __('Amount') }}" class="font-semibold" />
                                <x-input id="name" type="number" class="block w-full mt-1"
                                    wire:model.defer="transaction.amount" autofocus />
                                <x-input-error for="name" class="mt-2" />
                                <x-label for="is_recurring" value="{{ __('Recurring?') }}" class="font-semibold" />
                                <x-checkbox wire:model="transaction.is_recurring" :value="$transaction->is_recurring ?? false" />
                                <x-input-error for="is_recurring" class="mt-2" />

                                <x-label for="transaction_date" value="{{ __('Transaction Date') }}"
                                    class="font-semibold" />
                                <x-input id="transaction_date" type="date" class="block w-full mt-1"
                                    wire:model.defer="transaction.transaction_date" />
                                <x-input-error for="transaction_date" class="mt-2" />

                                <x-label for="note" value="{{ __('Note') }}" class="font-semibold" />
                                <x-input id="note" type="text" class="block w-full mt-1"
                                    wire:model.defer="transaction.note" />
                                <x-input-error for="note" class="mt-2" />
                                <div class="mt-5">
                                    <x-button>
                                        {{ __('Save') }}
                                    </x-button>
                                    <x-action-message class="mr-3" on="created">
                                        {{ __('Created.') }}
                                    </x-action-message>

                                </div>
                            </div>
                        </div>
                        @if ($transaction->is_recurring)
                        <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                            <div class="h-full rounded-xl">
                                <label for="recurring_frequency" value="">
                                    <h5 class="pt-2 mb-6 font-bold ">{{ __('Recurring') }}</h5>
                                </label>
                                {{-- <div class="flex content-between mt-1"> --}}
                                <select class="w-full mt-3" wire:model.defer="transaction.recurring_frequency">
                                    <option>{{ __('Choose frequency') }}</option>
                                    @foreach (range(1, 30) as $number)
                                        <option value="{{ $number }}">{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="recurring_frequency" class="mt-2" />
                                <select class="w-full mt-3" wire:model.defer="transaction.recurring_period">
                                    <option>{{ __('Choose period') }}</option>
                                    <option value="day">{{ __('Day') }}</option>
                                    <option value="week">{{ __('Week') }}</option>
                                    <option value="month">{{ __('Month') }}</option>
                                    <option value="year">{{ __('Year') }}</option>
                                </select>
                                <x-input-error for="recurring_period" class="mt-2" />
                                {{-- </div> --}}
                                <x-label for="recurring_on" value="{{ __('Recurring on') }}"
                                    class="mt-3 font-semibold" />
                                <x-input id="recurring_on" type="date" class="block w-full mt-3"
                                    wire:model.defer="transaction.recurring_on" autofocus />
                                <x-input-error for="recurring_on" class="mt-2" />
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-5/12 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="relative h-full overflow-hidden bg-cover rounded-xl">
                    <div class="relative flex flex-col flex-auto h-full p-4">
                        <label for="" value="">
                            <h5 class="mb-6 font-bold">{{ __('Category') }}</h5>
                        </label>
                        <div class="flex flex-wrap h-full">
                            @forelse ($this->categories ?? [] as $category)
                                <div class="block w-full md:w-1/2">
                                    <label class="">
                                        <x-radio wire:model="transaction.category_id" :value="$category->id" />
                                        <span
                                            class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="flex items-center justify-between">
                                    <div class="break-all dark:text-white">
                                        {{ __('There is no category yet.') }}
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <x-primary-button wire:click.prevent="$emit('showCreateCategoryModalUpdated', true)"
                            wire:loading.attr="disabled">{{ __('Add new category') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
</div>