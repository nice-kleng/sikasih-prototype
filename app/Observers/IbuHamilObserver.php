<?php

namespace App\Observers;

use App\Models\IbuHamil;
use App\Models\User;

class IbuHamilObserver
{
    /**
     * Handle the IbuHamil "deleting" event.
     *
     * @param  \App\Models\IbuHamil  $ibuHamil
     * @return void
     */
    public function deleting(IbuHamil $ibuHamil): void
    {
        // Delete the associated user account when Ibu Hamil is deleted
        if ($ibuHamil->akun) {
            $ibuHamil->akun->delete();
        }
    }
}
