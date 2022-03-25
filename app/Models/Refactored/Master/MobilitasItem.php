<?php

namespace App\Models\Refactored\Master;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idmobilitas
 * @property string     $nama
 */
class MobilitasItem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mobilitas_item';

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
        'idmobilitas', 'nama'
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
        'idmobilitas' => 'int', 'nama' => 'string'
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
