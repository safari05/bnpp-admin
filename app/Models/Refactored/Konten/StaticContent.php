<?php

namespace App\Models\Refactored\Konten;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $latar_belakang
 * @property string     $maksud
 * @property string     $tujuan
 */
class StaticContent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'static_content';

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
        'latar_belakang', 'maksud', 'tujuan'
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
        'latar_belakang' => 'string', 'maksud' => 'string', 'tujuan' => 'string'
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
