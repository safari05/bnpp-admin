<?php

namespace App\Models\Refactored\Kecamatan;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $lokpriid
 * @property string     $name
 * @property string     $nickname
 * @property boolean    $active
 */
class KecamatanLokpri extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_lokpri';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'lokpriid';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lokpriid', 'name', 'nickname', 'active'
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
        'lokpriid' => 'int', 'name' => 'string', 'nickname' => 'string', 'active' => 'int'
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
