<?php

namespace App\Filament\Widgets;

use App\Models\DeteksiRisiko;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DeteksiRisikoStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        // Query berdasarkan role
        if ($user->hasRole('puskesmas')) {
            $query = DeteksiRisiko::where('puskesmas_id', $user->puskesmas->id);
        } else {
            $query = DeteksiRisiko::query();
        }

        // Hitung statistik
        $totalDeteksi = $query->count();
        $risikoRendah = (clone $query)->where('kategori', 'KRR (Kehamilan Risiko Rendah)')->count();
        $risikoTinggi = (clone $query)->where('kategori', 'KRT (Kehamilan Risiko Tinggi)')->count();
        $risikoSangatTinggi = (clone $query)->where('kategori', 'KRST (Kehamilan Risiko Sangat Tinggi)')->count();

        // Deteksi bulan ini
        $bulanIni = (clone $query)->whereMonth('waktu_deteksi', now()->month)
            ->whereYear('waktu_deteksi', now()->year)
            ->count();

        // Deteksi bulan lalu
        $bulanLalu = (clone $query)->whereMonth('waktu_deteksi', now()->subMonth()->month)
            ->whereYear('waktu_deteksi', now()->subMonth()->year)
            ->count();

        // Hitung persentase perubahan
        $persentasePerubahan = $bulanLalu > 0
            ? round((($bulanIni - $bulanLalu) / $bulanLalu) * 100, 1)
            : 0;

        return [
            Stat::make('Total Deteksi Risiko', $totalDeteksi)
                ->description('Total pemeriksaan yang telah dilakukan')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info')
                ->chart([7, 12, 8, 15, 10, 18, 25]),

            Stat::make('Risiko Rendah (KRR)', $risikoRendah)
                ->description($totalDeteksi > 0 ? round(($risikoRendah / $totalDeteksi) * 100, 1) . '% dari total' : '0%')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([5, 8, 6, 10, 7, 12, 15]),

            Stat::make('Risiko Tinggi (KRT)', $risikoTinggi)
                ->description($totalDeteksi > 0 ? round(($risikoTinggi / $totalDeteksi) * 100, 1) . '% dari total' : '0%')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning')
                ->chart([2, 3, 2, 4, 3, 5, 7]),

            Stat::make('Risiko Sangat Tinggi (KRST)', $risikoSangatTinggi)
                ->description($totalDeteksi > 0 ? round(($risikoSangatTinggi / $totalDeteksi) * 100, 1) . '% dari total' : '0%')
                ->descriptionIcon('heroicon-m-shield-exclamation')
                ->color('danger')
                ->chart([0, 1, 0, 1, 0, 1, 3]),

            Stat::make('Deteksi Bulan Ini', $bulanIni)
                ->description(
                    $persentasePerubahan > 0
                        ? $persentasePerubahan . '% lebih tinggi dari bulan lalu'
                        : ($persentasePerubahan < 0
                            ? abs($persentasePerubahan) . '% lebih rendah dari bulan lalu'
                            : 'Sama dengan bulan lalu')
                )
                ->descriptionIcon($persentasePerubahan > 0 ? 'heroicon-m-arrow-trending-up' : ($persentasePerubahan < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-minus'))
                ->color($persentasePerubahan > 0 ? 'success' : ($persentasePerubahan < 0 ? 'danger' : 'gray'))
                ->chart(array_map(fn() => rand(0, 30), range(1, 7))),

            Stat::make('Rata-rata Skor Risiko', function () use ($query) {
                $avgSkor = (clone $query)->avg('total_skor');
                return $avgSkor ? round($avgSkor, 2) : '0';
            })
                ->description(function () use ($query) {
                    $avgSkor = (clone $query)->avg('total_skor');
                    if ($avgSkor < 2) {
                        return 'Kategori Risiko Rendah';
                    } elseif ($avgSkor < 6) {
                        return 'Kategori Risiko Tinggi';
                    } else {
                        return 'Kategori Risiko Sangat Tinggi';
                    }
                })
                ->descriptionIcon('heroicon-m-calculator')
                ->color(function () use ($query) {
                    $avgSkor = (clone $query)->avg('total_skor');
                    if ($avgSkor < 2) {
                        return 'success';
                    } elseif ($avgSkor < 6) {
                        return 'warning';
                    } else {
                        return 'danger';
                    }
                })
                ->chart([3, 4, 3, 5, 4, 6, 5]),
        ];
    }

    protected static ?string $pollingInterval = null;
}
