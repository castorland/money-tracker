<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Test') }} <a href="https://codepen.io/netsi1964/full/QbLLGW/" target="_blank" rel="noopener noreferrer">execCommands</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                {{-- <div class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700"> --}}
                <div class="flex justify-center min-h-screen min-w-screen">
                    <div class="w-full max-w-6xl p-5 mx-auto text-black bg-white shadow-lg rounded-xl"
                        x-data="wisywyg($refs.htmlEditor)">
                        <div class="overflow-hidden border border-gray-200 rounded-md">
                            <div class="flex w-full text-xl text-gray-600 border-b border-gray-200">
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:bg-gray-100 active:bg-gray-100"
                                    @click="format('bold')">
                                    <svg class="mx-auto" width="24" height="24" focusable="false"><path d="M7.8 19c-.3 0-.5 0-.6-.2l-.2-.5V5.7c0-.2 0-.4.2-.5l.6-.2h5c1.5 0 2.7.3 3.5 1 .7.6 1.1 1.4 1.1 2.5a3 3 0 01-.6 1.9c-.4.6-1 1-1.6 1.2.4.1.9.3 1.3.6s.8.7 1 1.2c.4.4.5 1 .5 1.6 0 1.3-.4 2.3-1.3 3-.8.7-2.1 1-3.8 1H7.8zm5-8.3c.6 0 1.2-.1 1.6-.5.4-.3.6-.7.6-1.3 0-1.1-.8-1.7-2.3-1.7H9.3v3.5h3.4zm.5 6c.7 0 1.3-.1 1.7-.4.4-.4.6-.9.6-1.5s-.2-1-.7-1.4c-.4-.3-1-.4-2-.4H9.4v3.8h4z" fill="inherit" fill-rule="evenodd"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('italic')">
                                    <svg class="mx-auto" width="24" height="24" focusable="false"><path d="M16.7 4.7l-.1.9h-.3c-.6 0-1 0-1.4.3-.3.3-.4.6-.5 1.1l-2.1 9.8v.6c0 .5.4.8 1.4.8h.2l-.2.8H8l.2-.8h.2c1.1 0 1.8-.5 2-1.5l2-9.8.1-.5c0-.6-.4-.8-1.4-.8h-.3l.2-.9h5.8z" fill-rule="evenodd"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 mr-1 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('underline')">
                                    <svg class="mx-auto" width="24" height="24" focusable="false"><path d="M16 5c.6 0 1 .4 1 1v5.5a4 4 0 01-.4 1.8l-1 1.4a5.3 5.3 0 01-5.5 1 5 5 0 01-1.6-1c-.5-.4-.8-.9-1.1-1.4a4 4 0 01-.4-1.8V6c0-.6.4-1 1-1s1 .4 1 1v5.5c0 .3 0 .6.2 1l.6.7a3.3 3.3 0 002.2.8 3.4 3.4 0 002.2-.8c.3-.2.4-.5.6-.8l.2-.9V6c0-.6.4-1 1-1zM8 17h8c.6 0 1 .4 1 1s-.4 1-1 1H8a1 1 0 010-2z" fill-rule="evenodd"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 border-l border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('formatBlock','P')">
                                    <span class="mx-auto font-bold text-md">P</span>
                                </button>
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('formatBlock','H1')">
                                    <span class="mx-auto font-bold text-md">H1</span>
                                </button>
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('formatBlock','H2')">
                                    <span class="mx-auto font-bold text-md">H2</span>
                                </button>
                                <button
                                    class="w-10 h-10 mr-1 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('formatBlock','H3')">
                                    <span class="mx-auto font-bold text-md">H3</span>
                                </button>
                                <button
                                    class="w-10 h-10 border-l border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('insertUnorderedList')">
                                    <svg class="mx-auto" width="24" height="24" focusable="false"><path d="M11 5h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0 6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0 6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zM4.5 6c0-.4.1-.8.4-1 .3-.4.7-.5 1.1-.5.4 0 .8.1 1 .4.4.3.5.7.5 1.1 0 .4-.1.8-.4 1-.3.4-.7.5-1.1.5-.4 0-.8-.1-1-.4-.4-.3-.5-.7-.5-1.1zm0 6c0-.4.1-.8.4-1 .3-.4.7-.5 1.1-.5.4 0 .8.1 1 .4.4.3.5.7.5 1.1 0 .4-.1.8-.4 1-.3.4-.7.5-1.1.5-.4 0-.8-.1-1-.4-.4-.3-.5-.7-.5-1.1zm0 6c0-.4.1-.8.4-1 .3-.4.7-.5 1.1-.5.4 0 .8.1 1 .4.4.3.5.7.5 1.1 0 .4-.1.8-.4 1-.3.4-.7.5-1.1.5-.4 0-.8-.1-1-.4-.4-.3-.5-.7-.5-1.1z" fill-rule="evenodd"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 mr-1 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('insertOrderedList')">
                                    <svg class="mx-auto" width="24" height="24" focusable="false"><path d="M10 17h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0-6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0-6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 110-2zM6 4v3.5c0 .3-.2.5-.5.5a.5.5 0 01-.5-.5V5h-.5a.5.5 0 010-1H6zm-1 8.8l.2.2h1.3c.3 0 .5.2.5.5s-.2.5-.5.5H4.9a1 1 0 01-.9-1V13c0-.4.3-.8.6-1l1.2-.4.2-.3a.2.2 0 00-.2-.2H4.5a.5.5 0 01-.5-.5c0-.3.2-.5.5-.5h1.6c.5 0 .9.4.9 1v.1c0 .4-.3.8-.6 1l-1.2.4-.2.3zM7 17v2c0 .6-.4 1-1 1H4.5a.5.5 0 010-1h1.2c.2 0 .3-.1.3-.3 0-.2-.1-.3-.3-.3H4.4a.4.4 0 110-.8h1.3c.2 0 .3-.1.3-.3 0-.2-.1-.3-.3-.3H4.5a.5.5 0 110-1H6c.6 0 1 .4 1 1z" fill-rule="evenodd"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 border-l border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('justifyLeft')">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path d="M4 19h16v2H4zm0-4h11v2H4zm0-4h16v2H4zm0-8h16v2H4zm0 4h11v2H4z"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('justifyCenter')">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path d="M4 19h16v2H4zm3-4h10v2H7zm-3-4h16v2H4zm0-8h16v2H4zm3 4h10v2H7z"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('justifyRight')">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path d="M4 19h16v2H4zm5-4h11v2H9zm-5-4h16v2H4zm0-8h16v2H4zm5 4h11v2H9z"></path></svg>
                                </button>
                                <button
                                    class="w-10 h-10 border-r border-gray-200 outline-none focus:outline-none hover:text-indigo-500 active:bg-gray-50"
                                    @click="format('justifyFull')">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path d="M4 7h16v2H4zm0-4h16v2H4zm0 8h16v2H4zm0 4h16v2H4zm2 4h12v2H6z"></path></svg>
                                </button>
                            </div>
                            <div class="w-full">
                                <iframe x-ref="htmlEditor" class="w-full overflow-y-auto h-96"></iframe>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- </div> --}}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('wisywyg', (el) => ({
                wysiwyg: null,
                element: el,

                init() {
                    this.wysiwyg = this.element
                    // Add CSS
                    this.wysiwyg.contentDocument.querySelector('head').innerHTML += `<style>
                        *,
                        ::after,
                        ::before {
                            box-sizing: border-box;
                        }

                        :root {
                            tab-size: 4;
                        }

                        html {
                            line-height: 1.15;
                            text-size-adjust: 100%;
                        }

                        body {
                            margin: 0px;
                            padding: 1rem 0.5rem;
                        }

                        body {
                            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
                        }
                    </style>`;

                    //init content
                    this.wysiwyg.contentDocument.body.innerHTML += `
                        <h1>Hello World!</h1>
                        <p>Welcome to the pure AlpineJS and Tailwind WYSIWYG.</p>
                        `;

                    // Make editable
                    this.wysiwyg.contentDocument.designMode = "on";
                },
                format(cmd, param) {
                    this.wysiwyg.contentDocument.execCommand(cmd, !1, param || null)
                }
            }))
        })
    </script>
</x-app-layout>
