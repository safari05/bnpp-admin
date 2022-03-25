<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $groups
 * @property string     $name
 * @property string     $title
 * @property string     $value
 */
class Setup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'setup';

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
        'ID', 'groups', 'name', 'title', 'value'
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
        'ID' => 'int', 'groups' => 'string', 'name' => 'string', 'title' => 'string', 'value' => 'string'
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
