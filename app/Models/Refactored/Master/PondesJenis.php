<?php

namespace App\Models\Refactored\Master;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idjenis
 * @property string     $keterangan
 */
class PondesJenis extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pondes_jenis';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idjenis';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idjenis', 'keterangan'
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
        'idjenis' => 'int', 'keterangan' => 'string'
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
