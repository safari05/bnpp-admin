<?php

namespace App\Models\Refactored\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idrole
 * @property string     $keterangan
 */
class UsersRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_role';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idrole';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idrole', 'keterangan'
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
        'idrole' => 'int', 'keterangan' => 'string'
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
