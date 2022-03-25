<?php

namespace App\Models\Refactored\Kepegawaian;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idkelembagaain
 * @property string     $keterangan
 */
class KepegawaianKelembagaan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kepegawaian_kelembagaan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idkelembagaan';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idkelembagaan', 'keterangan','canDelete'
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
        'idkelembagaain' => 'int', 'keterangan' => 'string'
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
