<?php

namespace App\Models\Refactored\Plb;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idplb
 * @property Date       $tanggal_lintas
 * @property string     $jenis_identitas
 * @property string     $nomor_identitas
 * @property string     $nama_pelintas
 * @property string     $tipe_penduduk_pelintas
 */
class PlbLintasan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plb_lintasan';

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
        'idplb', 'tanggal_lintas', 'jam_lintas', 'jenis_identitas', 'nomor_identitas', 'nama_pelintas', 'gender_pelintas', 'tipe_penduduk_pelintas'
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
        'idplb' => 'int', 'tanggal_lintas' => 'date', 'jenis_identitas' => 'string', 'nomor_identitas' => 'string', 'nama_pelintas' => 'string', 'tipe_penduduk_pelintas' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'tanggal_lintas'
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
