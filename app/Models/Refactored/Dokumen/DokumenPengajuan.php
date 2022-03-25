<?php

namespace App\Models\Refactored\Dokumen;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idpengajuan
 * @property int        $iddokumen
 * @property int        $iduser_pengaju
 * @property DateTime   $waktu_pengajuan
 * @property boolean    $status_pengajuan
 */
class DokumenPengajuan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dokumen_pengajuan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idpengajuan';
    protected $fillable = [
        'idpengajuan', 'iddokumen', 'iduser_pengaju', 'waktu_pengajuan', 'status_pengajuan'
    ];
    public $timestamps = false;

    public function dokumen(){
        return $this->hasOne(Dokumen::class, 'id', 'iddokumen');
    }

    public function pengaju(){
        return $this->hasOne(User::class, 'iduser', 'iduser_pengaju');
    }
}
