<div {{ $attributes->merge(['class' => 'md:grid md:gap-6']) }}>
    @isset($title)
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>
    @endisset
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            {{ $content }}
        </div>
    </div>
</div>
