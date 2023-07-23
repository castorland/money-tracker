<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-block px-8 py-2 mb-0 text-xs font-bold text-center uppercase align-middle transition-all bg-gradient-to-tl from-teal-400 to-emerald-600 border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-teal-500 text-white hover:opacity-75']) }}>
    {{ $slot }}
</button>
