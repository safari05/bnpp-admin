<?php

namespace App\Models\Refactored\PLB;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idplb
 * @property int        $idlintas
 * @property int        $idorang
 * @property int        $jumlah_orang
 */
class PlbLogLintasanOrang extends Model
{
    use Compoships;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plb_log_lintasan_orang';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idorang';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idplb', 'idlintas', 'idorang', 'jumlah_orang'
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
        'idplb' => 'int', 'idlintas' => 'int', 'idorang' => 'int', 'jumlah_orang' => 'int'
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
