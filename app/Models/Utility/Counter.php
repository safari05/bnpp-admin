<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $screenFile
 * @property string     $content
 * @property string     $ip
 * @property string     $host
 * @property string     $os
 * @property string     $memberID
 * @property DateTime   $date
 * @property boolean    $active
 */
class Counter extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'counter';

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
        'ID', 'screenFile', 'content', 'ip', 'host', 'os', 'memberID', 'date', 'active'
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
        'ID' => 'int', 'screenFile' => 'string', 'content' => 'string', 'ip' => 'string', 'host' => 'string', 'os' => 'string', 'memberID' => 'string', 'date' => 'datetime', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date'
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
