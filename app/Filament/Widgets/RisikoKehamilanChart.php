<?php

namespace App\Filament\Widgets;

use App\Models\DeteksiRisiko;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class RisikoKehamilanChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Kategori Risiko Kehamilan';

    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $user = Auth::user();

        // Query berdasarkan role
        if ($user->hasRole('puskesmas')) {
            $query = DeteksiRisiko::where('puskesmas_id', $user->puskesmas->id);
        } else {
            $query = DeteksiRisiko::query();
        }

        $krr = (clone $query)->where('kategori', 'KRR (Kehamilan Risiko Rendah)')->count();
        $krt = (clone $query)->where('kategori', 'KRT (Kehamilan Risiko Tinggi)')->count();
        $krst = (clone $query)->where('kategori', 'KRST (Kehamilan Risiko Sangat Tinggi)')->count();
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [$krr, $krt, $krst],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',  // green for KRR
                        'rgba(251, 191, 36, 0.8)',  // yellow for KRT
                        'rgba(239, 68, 68, 0.8)',   // red for KRST
                    ],
                    'borderColor' => [
                        'rgba(34, 197, 94, 1)',
                        'rgba(251, 191, 36, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'Risiko Rendah (KRR)',
                'Risiko Tinggi (KRT)',
                'Risiko Sangat Tinggi (KRST)',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
