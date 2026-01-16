<div class="space-y-4">
    @php
        $hasDangerFaktors = false;
        $hasWarningFaktors = false;

        foreach ($faktors['danger'] as $faktor) {
            if ($record->{$faktor['field']}) {
                $hasDangerFaktors = true;
                break;
            }
        }

        foreach ($faktors['warning'] as $faktor) {
            if ($record->{$faktor['field']}) {
                $hasWarningFaktors = true;
                break;
            }
        }
    @endphp

    @if (!$hasDangerFaktors && !$hasWarningFaktors)
        <div
            class="flex items-center justify-center p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-2 text-sm font-medium text-green-900 dark:text-green-100">Tidak ada faktor risiko
                    terdeteksi</p>
                <p class="mt-1 text-xs text-green-700 dark:text-green-300">Kehamilan dalam kondisi baik</p>
            </div>
        </div>
    @endif

    {{-- Faktor Risiko Tinggi (8 Poin) --}}
    @if ($hasDangerFaktors)
        <div class="space-y-2">
            <h4 class="text-sm font-semibold text-red-900 dark:text-red-100 flex items-center gap-2">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Faktor Risiko Tinggi
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach ($faktors['danger'] as $faktor)
                    @if ($record->{$faktor['field']})
                        <div
                            class="flex items-center gap-2 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-red-900 dark:text-red-100">{{ $faktor['label'] }}</p>
                                <p class="text-xs text-red-700 dark:text-red-300">Skor: {{ $faktor['poin'] }} poin</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    {{-- Faktor Risiko Sedang (4 Poin) --}}
    @if ($hasWarningFaktors)
        <div class="space-y-2">
            <h4 class="text-sm font-semibold text-yellow-900 dark:text-yellow-100 flex items-center gap-2">
                <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Faktor Risiko Sedang
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach ($faktors['warning'] as $faktor)
                    @if ($record->{$faktor['field']})
                        <div
                            class="flex items-center gap-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                            <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-yellow-900 dark:text-yellow-100">
                                    {{ $faktor['label'] }}</p>
                                <p class="text-xs text-yellow-700 dark:text-yellow-300">Skor: {{ $faktor['poin'] }} poin
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>
