<?php

namespace App\Models\Refactored\Desa;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $nama_kades
 * @property string     $pendidikan_kades
 * @property string     $alamat_desa
 * @property string     $regulasi
 * @property string     $kodepos
 * @property boolean    $status_kantor
 * @property boolean    $kondisi_kantor
 * @property string     $foto_kantor
 * @property boolean    $status_balai
 * @property boolean    $kondisi_balai
 * @property string     $foto_balai
 */
class DesaKades extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desa_kades';

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
        'nama_kades', 'gender_kades', 'pendidikan_kades', 'alamat_desa', 'regulasi', 'kodepos', 'status_kantor', 'kondisi_kantor', 'foto_kantor', 'status_balai', 'kondisi_balai', 'foto_balai'
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
        'nama_kades' => 'string', 'pendidikan_kades' => 'string', 'alamat_desa' => 'string', 'regulasi' => 'string', 'kodepos' => 'string', 'status_kantor' => 'int', 'kondisi_kantor' => 'int', 'foto_kantor' => 'string', 'status_balai' => 'int', 'kondisi_balai' => 'int', 'foto_balai' => 'string'
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
