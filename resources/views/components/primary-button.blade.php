<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-sky-500 dark:bg-sky-800 border border-sky-300 dark:border-sky-500 rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-sky-600 dark:hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
