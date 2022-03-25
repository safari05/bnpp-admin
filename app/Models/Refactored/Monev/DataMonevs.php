<?php

namespace App\Models\Refactored\Monev;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $nama
 * @property string     $jabatan
 * @property string     $alamat_kantor
 * @property string     $email
 * @property string     $no_hp
 * @property string     $provinsi
 * @property string     $kabupaten
 * @property string     $kecamatan
 * @property float      $rata_rata_ciq
 * @property float      $rata_rata_pap
 * @property boolean    $lokpri_batas_darat
 * @property boolean    $lokpri_batas_laut
 * @property boolean    $lokpri_pksn_darat
 * @property boolean    $lokpri_pksn_laut
 * @property boolean    $lokpri_ppkt
 * @property int        $created_at
 * @property int        $updated_at
 */
class DataMonevs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'data_monevs';

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
        'nama', 'jabatan', 'alamat_kantor', 'email', 'no_hp', 'provinsi', 'kabupaten', 'kecamatan', 'rata_rata_ciq', 'rata_rata_pap', 'lokpri_batas_darat', 'lokpri_batas_laut', 'lokpri_pksn_darat', 'lokpri_pksn_laut', 'lokpri_ppkt', 'created_at', 'updated_at'
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
        'nama' => 'string', 'jabatan' => 'string', 'alamat_kantor' => 'string', 'email' => 'string', 'no_hp' => 'string', 'provinsi' => 'string', 'kabupaten' => 'string', 'kecamatan' => 'string', 'rata_rata_ciq' => 'double', 'rata_rata_pap' => 'double', 'lokpri_batas_darat' => 'boolean', 'lokpri_batas_laut' => 'boolean', 'lokpri_pksn_darat' => 'boolean', 'lokpri_pksn_laut' => 'boolean', 'lokpri_ppkt' => 'boolean', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
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
    public function detail(){
        return $this->hasMany(DetailMonevs::class, 'monev_id', 'id');
    }
}
