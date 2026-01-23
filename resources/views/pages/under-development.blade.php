@extends('layouts.app')
@section('title', 'Fitur Dalam Pengembangan')

@section('content')
    <div class="header">
        <div class="header-content">
            <a href="javascript:history.back()" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="flex-grow-1">
                <h1>Fitur Dalam Pengembangan</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="text-center py-5">
            <!-- Icon Animasi -->
            <div class="mb-4">
                <div class="dev-icon-wrapper">
                    <i class="fas fa-tools fa-5x text-primary mb-3 dev-icon"></i>
                </div>
            </div>

            <!-- Pesan Utama -->
            <h3 class="fw-bold mb-3" style="color: #ff6b9d;">Sedang Dalam Pengembangan</h3>
            <p class="text-muted mb-4 px-3" style="font-size: 15px; line-height: 1.6;">
                Fitur ini sedang kami kembangkan untuk memberikan pengalaman terbaik bagi Anda.
            </p>

            <!-- Info Card -->
            <div class="card-custom text-start">
                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-lightbulb fa-2x me-3" style="color: #ffc107;"></i>
                    <div>
                        <h6 class="fw-bold mb-2">Yang Sedang Kami Kerjakan:</h6>
                        <ul class="list-unstyled mb-0 text-muted" style="font-size: 14px;">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Desain antarmuka yang
                                lebih baik</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Fitur yang lebih lengkap
                            </li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Performa yang lebih
                                cepat</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card-custom text-start mt-3">
                <div class="d-flex align-items-start">
                    <i class="fas fa-calendar-alt fa-2x me-3" style="color: #ff6b9d;"></i>
                    <div>
                        <h6 class="fw-bold mb-2">Estimasi Waktu:</h6>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Fitur ini direncanakan akan tersedia dalam waktu dekat. Kami akan memberikan notifikasi saat
                            fitur sudah siap digunakan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary-custom w-100 mb-2">
                    <i class="fas fa-home me-2"></i>Kembali ke Beranda
                </a>
                <a href="mailto:nicecode9@gmail.com" class="btn btn-outline-primary w-100">
                    <i class="fas fa-envelope me-2"></i>Hubungi Tim Pengembang
                </a>
            </div>

            <!-- Social Proof -->
            <div class="mt-4 pt-3 border-top">
                <p class="text-muted mb-2" style="font-size: 13px;">
                    <i class="fas fa-users me-2"></i>Bergabunglah dengan <strong>1000+ ibu hamil</strong> yang sudah
                    menggunakan SIKASIH
                </p>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .dev-icon-wrapper {
                position: relative;
                display: inline-block;
            }

            .dev-icon {
                animation: bounce 2s infinite;
            }

            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-20px);
                }
            }

            .text-primary {
                color: #ff6b9d !important;
            }

            .card-custom {
                transition: transform 0.3s;
            }

            .card-custom:hover {
                transform: translateY(-5px);
            }

            .list-unstyled li {
                padding-left: 5px;
            }

            /* Progress bar animation (optional) */
            .progress-bar-animated {
                background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
                animation: progress 2s ease-in-out infinite;
            }

            @keyframes progress {
                0% {
                    width: 30%;
                }

                50% {
                    width: 70%;
                }

                100% {
                    width: 30%;
                }
            }
        </style>
    @endpush
@endsection
