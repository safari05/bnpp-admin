<?php

namespace App\Models\Refactored\Kepegawaian;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idoperasional
 * @property string     $keterangan
 */
class KepegawaianOperasional extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kepegawaian_operasional';

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
        'idoperasional', 'keterangan'
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
        'idoperasional' => 'int', 'keterangan' => 'string'
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
