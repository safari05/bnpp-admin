<?php

namespace App\Models\Refactored\Desa;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $luas_wilayah
 * @property string     $ibukota_desa
 * @property string     $alamat_desa
 * @property string     $regulasi_desa
 * @property string     $batas_barat
 * @property string     $batas_timur
 * @property string     $batas_selatan
 * @property string     $batas_utara
 * @property boolean    $batas_negara_jenis
 * @property string     $batas_negara
 * @property string     $jarak_ke_kabupaten
 * @property string     $jarak_ke_kecamatan
 * @property boolean    $status_plb
 * @property string     $nama_plb
 */
class DesaWilayah extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desa_wilayah';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'luas_wilayah', 'ibukota_desa', 'alamat_desa', 'regulasi_desa', 'batas_barat', 'batas_timur', 'batas_selatan', 'batas_utara', 'batas_negara_jenis', 'batas_negara', 'jarak_ke_kabupaten', 'jarak_ke_kecamatan', 'status_plb', 'nama_plb'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'luas_wilayah' => 'string', 'ibukota_desa' => 'string', 'alamat_desa' => 'string', 'regulasi_desa' => 'string', 'batas_barat' => 'string', 'batas_timur' => 'string', 'batas_selatan' => 'string', 'batas_utara' => 'string', 'batas_negara_jenis' => 'int', 'batas_negara' => 'string', 'jarak_ke_kabupaten' => 'float', 'jarak_ke_kecamatan' => 'float', 'status_plb' => 'int', 'nama_plb' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...
}
