<div class="flex items-center justify-center h-screen">
    <div class="max-w-full sm:p-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="mb-2 text-xl font-medium leading-6 text-gray-900">
                Create a Private Shortlink
            </h3>

            <p>
                Enter a link below to create a shortlink. This link will only be accessible to other Alleyinz.
                <img src="/alley.png" class="w-6 h-6 inline ml-3 relative top-[-2px]" />
            </p>

            @if ($this->link)
                <div x-data="{ copied: false }" class="p-4 mt-5 border-l-4 border-indigo-400 bg-indigo-50">
                    <input
                        readonly
                        id="shortlink"
                        type="text"
                        value="{{ route('link', ['hash' => $this->link->hash]) }}"
                        class="block w-full p-4 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />

                    <button
                        type="button"
                        onclick="copyToClipboard('shortlink')"
                        @click="copied = true"
                        class="inline-flex items-center px-4 py-2 mt-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm grow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <span x-show="!copied">Copy URL</span>
                        <span x-cloak x-show="copied">Copied!</span>
                    </button>
                    <a
                        href="/"
                        class="inline-flex items-center px-4 py-2 mt-3 ml-2 text-sm font-medium text-indigo-500 bg-indigo-200 border border-transparent rounded-md shadow-sm hover:bg-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Create Another
                    </a>
                </div>
            @endif

            <form wire:submit.prevent="submit" class="mt-5 space-y-2">
                @error('url')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror

                <div class="flex flex-row">
                    <label for="url" class="sr-only">Link</label>

                    <input
                        autofocus
                        wire:model="url"
                        type="url"
                        name="url"
                        id="url"
                        class="block p-4 mr-4 border-gray-500 rounded-md shadow grow focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="https://example.com" />

                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-center text-white bg-indigo-600 border border-transparent rounded-md shadow-sm w-44 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Create Shortlink
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    navigator.clipboard.writeText(document.getElementById(elementId).value);
}
</script>
