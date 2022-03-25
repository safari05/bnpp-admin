<?php

namespace App\Models\Refactored\Plb;

use App\Models\Refactored\PLB\PlbCoord;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int        $idplb
 * @property string     $nama_plb
 * @property boolean    $jenis_plb
 * @property string     $tipe_plb
 * @property boolean    $status_imigrasi
 * @property boolean    $status_karantina_kesehatan
 * @property boolean    $status_karantina_pertanian
 * @property boolean    $status_karantina_perikanan
 * @property boolean    $status_keamanan_tni
 * @property boolean    $status_keamanan_polri
 * @property boolean    $jenis_perbatasan
 * @property string     $batas_negara_timur
 * @property string     $batas_negara_barat
 * @property string     $batas_negara_utara
 * @property string     $batas_negara_selatan
 */
class Plb extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plb';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idplb';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idplb', 'nama_plb', 'jenis_plb', 'tipe_plb', 'alamat_plb', 'status_imigrasi', 'status_karantina_kesehatan', 'status_karantina_pertanian', 'status_karantina_perikanan', 'status_keamanan_tni', 'status_keamanan_polri', 'jenis_perbatasan', 'batas_negara_timur', 'batas_negara_barat', 'batas_negara_utara', 'batas_negara_selatan', 'kecamatanid', 'desaid', 'deleted_at'
    ];

    public function kecamatan(){
        return $this->hasOne(UtilsKecamatan::class, 'id', 'kecamatanid');
    }
    public function desa(){
        return $this->hasOne(UtilsDesa::class, 'id', 'desaid');
    }

    public function coord(){
        return $this->hasOne(PlbCoord::class, 'idplb', 'idplb');
    }
}
