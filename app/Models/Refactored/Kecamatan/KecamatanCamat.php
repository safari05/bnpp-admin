<?php

namespace App\Models\Refactored\Kecamatan;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $nama_camat
 * @property string     $pendidikan_camat
 * @property string     $alamat_kantor
 * @property string     $kodepos_kantor
 * @property string     $regulasi
 * @property boolean    $status_kantor
 * @property boolean    $kondisi_kantor
 * @property string     $foto_kantor
 * @property boolean    $status_balai
 * @property boolean    $kondisi_balai
 * @property string     $foto_balai
 */
class KecamatanCamat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_camat';

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
        'nama_camat', 'gender_camat', 'pendidikan_camat', 'alamat_kantor', 'kodepos_kantor', 'regulasi', 'status_kantor', 'kondisi_kantor', 'foto_kantor', 'status_balai', 'kondisi_balai', 'foto_balai'
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
        'nama_camat' => 'string', 'pendidikan_camat' => 'string', 'alamat_kantor' => 'string', 'kodepos_kantor' => 'string', 'regulasi' => 'string', 'status_kantor' => 'int', 'kondisi_kantor' => 'int', 'foto_kantor' => 'string', 'status_balai' => 'int', 'kondisi_balai' => 'int', 'foto_balai' => 'string'
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
