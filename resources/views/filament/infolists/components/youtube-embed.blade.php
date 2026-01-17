<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
        $record = $getRecord();
        $youtubeId = $record->youtube_id;
    @endphp

    @if ($youtubeId)
        <div class="space-y-4">
            <!-- YouTube Embed Player -->
            <div class="relative w-full overflow-hidden rounded-xl shadow-2xl border-4 border-gray-200 dark:border-gray-700"
                style="padding-bottom: 56.25%;">
                <iframe class="absolute top-0 left-0 w-full h-full"
                    src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>

            <!-- Video Info Bar -->
            <div
                class="flex flex-wrap items-center justify-between gap-4 p-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-red-100 dark:border-gray-600">
                <div class="flex items-center gap-3">
                    <!-- YouTube Logo -->
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </div>

                    <!-- Video ID -->
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Video ID</p>
                        <code
                            class="px-2 py-1 text-sm font-mono font-semibold text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 rounded border border-red-200 dark:border-red-800">
                            {{ $youtubeId }}
                        </code>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <!-- Watch on YouTube -->
                    <a href="https://www.youtube.com/watch?v={{ $youtubeId }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Tonton di YouTube
                    </a>

                    <!-- Copy Link -->
                    <button onclick="copyToClipboard('https://www.youtube.com/watch?v={{ $youtubeId }}')"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200 dark:border-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin Link
                    </button>
                </div>
            </div>
        </div>

        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    // Show success notification (you can customize this)
                    alert('Link berhasil disalin!');
                }, function(err) {
                    console.error('Gagal menyalin: ', err);
                });
            }
        </script>
    @else
        <div
            class="p-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
            <svg class="w-16 h-16 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            <p class="text-base font-medium">Tidak ada video yang tersedia</p>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">YouTube ID belum diatur</p>
        </div>
    @endif
</x-dynamic-component>
