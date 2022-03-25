<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $location
 * @property string     $image
 * @property string     $caption
 * @property string     $link
 * @property boolean    $active
 */
class Caption extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'caption';

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
        'ID', 'location', 'image', 'caption', 'link', 'active'
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
        'ID' => 'int', 'location' => 'string', 'image' => 'string', 'caption' => 'string', 'link' => 'string', 'active' => 'boolean'
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
