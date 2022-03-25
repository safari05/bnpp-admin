<?php

namespace App\Traits;

use App\Models\Refactored\Users\UsersCamat;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait UserKecamatan
{
    /**
     * @return array id user yang berhubungan dengan kecamatan
     */
    public function getUserKecamatan(){
        $iduser = [];
        if (Auth::user()->idrole == 5) {
            $idkec = @Auth::user()->kecamatan->idkecamatan;
            $iduser = UsersCamat::where('idkecamatan', $idkec)->get()->pluck('iduser')->toArray();
        }
        return $iduser;
    }
}
