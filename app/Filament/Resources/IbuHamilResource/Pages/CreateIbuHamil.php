<?php

namespace App\Filament\Resources\IbuHamilResource\Pages;

use App\Filament\Resources\IbuHamilResource;
use App\Models\User;
use App\Models\IbuHamil;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateIbuHamil extends CreateRecord
{
    protected static string $resource = IbuHamilResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            // 1. Generate unique email
            $email = Str::slug($data['nama_lengkap'], '') . rand(100, 999) . '@sikasih.id';

            // 2. Create User account
            $user = User::create([
                'name' => $data['nama_lengkap'],
                'email' => $email,
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]);

            // 3. Assign role 'ibu_hamil' with explicit web guard
            $user->assignRole(\Spatie\Permission\Models\Role::findByName('ibu_hamil', 'web'));

            // 4. Create IbuHamil record manually to ensure user_id is passed
            $ibuHamil = new IbuHamil();
            $ibuHamil->fill($data);
            $ibuHamil->user_id = $user->id; // Explicit assignment to bypass any magic

            // 5. Set puskesmas_id if it's missing (for puskesmas users)
            if (!isset($data['puskesmas_id']) && auth()->user()->isPuskesmas()) {
                $ibuHamil->puskesmas_id = auth()->user()->puskesmas->id;
            }

            $ibuHamil->save();

            // 6. Handle nested DataSuami relationship
            if (isset($data['dataSuami']) && is_array($data['dataSuami'])) {
                $ibuHamil->dataSuami()->create($data['dataSuami']);
            }

            return $ibuHamil;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
