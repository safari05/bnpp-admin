<?php

namespace App\Models\Refactored\Users;

use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $iduser
 */
class UsersCamat extends Model
{
    protected $table = 'users_camat';
    protected $primaryKey = 'iduser';
    protected $fillable = [
        'iduser', 'idkecamatan'
    ];
    public $timestamps = false;
    public function user(){
        return $this->hasOne(User::class, 'iduser', 'iduser');
    }

    public function kecamatan(){
        return $this->hasOne(UtilsKecamatan::class, 'id', 'idkecamatan');
    }
}
