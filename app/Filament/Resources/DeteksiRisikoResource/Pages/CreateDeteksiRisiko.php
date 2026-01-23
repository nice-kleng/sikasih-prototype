<?php

namespace App\Filament\Resources\DeteksiRisikoResource\Pages;

use App\Filament\Resources\DeteksiRisikoResource;
use App\Models\DataReproduksi;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeteksiRisiko extends CreateRecord
{
    protected static string $resource = DeteksiRisikoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Deteksi risiko berhasil disimpan';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Data reproduksi akan dihandle di afterCreate
        $this->dataReproduksi = $data['dataReproduksi'] ?? [];
        unset($data['dataReproduksi']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Simpan data reproduksi
        if (!empty($this->dataReproduksi)) {
            DataReproduksi::create([
                'deteksi_risiko_id' => $this->record->id,
                ...$this->dataReproduksi,
            ]);
        }
    }

    private $dataReproduksi = [];
}

// ============================================================================

// File: app/Filament/Resources/DeteksiRisikoResource/Pages/EditDeteksiRisiko.php

namespace App\Filament\Resources\DeteksiRisikoResource\Pages;

use App\Filament\Resources\DeteksiRisikoResource;
use App\Models\DataReproduksi;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeteksiRisiko extends EditRecord
{
    protected static string $resource = DeteksiRisikoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Deteksi risiko berhasil diperbarui';
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load data reproduksi
        if ($this->record->dataReproduksi) {
            $data['dataReproduksi'] = [
                'usia_pertama_menikah' => $this->record->dataReproduksi->usia_pertama_menikah,
                'usia_hamil_pertama' => $this->record->dataReproduksi->usia_hamil_pertama,
                'jumlah_kehamilan' => $this->record->dataReproduksi->jumlah_kehamilan,
                'jumlah_persalinan' => $this->record->dataReproduksi->jumlah_persalinan,
                'jumlah_anak_hidup' => $this->record->dataReproduksi->jumlah_anak_hidup,
                'jumlah_keguguran' => $this->record->dataReproduksi->jumlah_keguguran,
                'riwayat_persalinan_sebelumnya' => $this->record->dataReproduksi->riwayat_persalinan_sebelumnya,
            ];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Data reproduksi akan dihandle di afterSave
        $this->dataReproduksi = $data['dataReproduksi'] ?? [];
        unset($data['dataReproduksi']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Update atau create data reproduksi
        if (!empty($this->dataReproduksi)) {
            DataReproduksi::updateOrCreate(
                ['deteksi_risiko_id' => $this->record->id],
                $this->dataReproduksi
            );
        }
    }

    private $dataReproduksi = [];
}
