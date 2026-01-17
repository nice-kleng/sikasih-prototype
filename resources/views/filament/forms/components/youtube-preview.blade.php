<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $youtubeId = $getRecord()?->youtube_id ?? null;
    @endphp

    @if ($youtubeId)
        <div class="space-y-3">
            <div class="relative w-full overflow-hidden rounded-lg shadow-lg" style="padding-bottom: 56.25%;">
                <iframe class="absolute top-0 left-0 w-full h-full"
                    src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        YouTube Video ID: <code
                            class="px-2 py-1 text-xs bg-gray-200 dark:bg-gray-700 rounded">{{ $youtubeId }}</code>
                    </span>
                </div>

                <a href="https://www.youtube.com/watch?v={{ $youtubeId }}" target="_blank"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Buka di YouTube
                </a>
            </div>
        </div>
    @else
        <div class="p-4 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            <p class="text-sm">Masukkan YouTube Video ID untuk melihat preview</p>
        </div>
    @endif
</x-dynamic-component>
