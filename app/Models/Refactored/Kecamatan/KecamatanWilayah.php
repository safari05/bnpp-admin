<?php

namespace App\Models\Refactored\Kecamatan;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $ibukota_kecamatan
 * @property string     $luas_wilayah
 * @property int        $jumlah_desa
 * @property int        $jumlah_kelurahan
 * @property int        $jumlah_pulau
 * @property string     $batas_barat
 * @property string     $batas_timur
 * @property string     $batas_utara
 * @property string     $batas_selatan
 * @property string     $batas_negara
 * @property boolean    $batas_negara_jenis
 * @property string     $jarak_ke_provinsi
 * @property string     $jarak_ke_kota
 * @property boolean    $status_plb
 * @property string     $nama_plb
 */
class KecamatanWilayah extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_wilayah';

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
        'ibukota_kecamatan', 'luas_wilayah', 'jumlah_desa', 'jumlah_kelurahan', 'jumlah_pulau', 'batas_barat', 'batas_timur', 'batas_utara', 'batas_selatan', 'batas_negara', 'batas_negara_jenis', 'jarak_ke_provinsi', 'jarak_ke_kota', 'status_plb', 'nama_plb'
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
        'ibukota_kecamatan' => 'string', 'luas_wilayah' => 'string', 'jumlah_desa' => 'int', 'jumlah_kelurahan' => 'int', 'jumlah_pulau' => 'int', 'batas_barat' => 'string', 'batas_timur' => 'string', 'batas_utara' => 'string', 'batas_selatan' => 'string', 'batas_negara' => 'string', 'batas_negara_jenis' => 'int', 'jarak_ke_provinsi' => 'float', 'jarak_ke_kota' => 'float', 'status_plb' => 'int', 'nama_plb' => 'string'
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
