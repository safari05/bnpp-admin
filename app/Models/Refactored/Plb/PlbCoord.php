<?php

namespace App\Models\Refactored\PLB;

use App\Models\Refactored\Plb\Plb;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idplb
 * @property float      $latitude
 * @property float      $longitude
 */
class PlbCoord extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plb_coord';

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
        'idplb', 'latitude', 'longitude'
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
        'idplb' => 'int', 'latitude' => 'double', 'longitude' => 'double'
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
