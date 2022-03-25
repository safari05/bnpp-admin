<?php

namespace App\Models\Refactored\Monev;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $layak_atas
 * @property int        $layak_bawah
 * @property int        $cukup_layak_atas
 * @property int        $cukup_layak_bawah
 * @property int        $tidak_layak_atas
 * @property int        $tidak_layak_bawah
 * @property int        $created_at
 * @property int        $updated_at
 */
class BobotKondisis extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bobot_kondisis';

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
        'layak_atas', 'layak_bawah', 'cukup_layak_atas', 'cukup_layak_bawah', 'tidak_layak_atas', 'tidak_layak_bawah', 'created_at', 'updated_at'
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
        'layak_atas' => 'int', 'layak_bawah' => 'int', 'cukup_layak_atas' => 'int', 'cukup_layak_bawah' => 'int', 'tidak_layak_atas' => 'int', 'tidak_layak_bawah' => 'int', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
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
}
