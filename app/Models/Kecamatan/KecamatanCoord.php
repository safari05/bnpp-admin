<?php

namespace App\Models\Kecamatan;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property int        $kabupatenkotaID
 * @property int        $provinsiID
 * @property int        $latitude
 * @property int        $longitude
 * @property string     $name
 */
class KecamatanCoord extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_coord';

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
        'ID', 'kabupatenkotaID', 'provinsiID', 'latitude', 'longitude', 'name'
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
        'ID' => 'int', 'kabupatenkotaID' => 'int', 'provinsiID' => 'int', 'latitude' => 'int', 'longitude' => 'int', 'name' => 'string'
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
