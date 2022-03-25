<?php

namespace App\Models\Kecamatan;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property DateTime   $date
 * @property string     $name
 * @property string     $nickname
 * @property string     $summary
 * @property boolean    $sortNum
 * @property string     $image
 * @property DateTime   $entryDate
 * @property string     $entryBy
 * @property string     $entryIP
 * @property boolean    $active
 */
class Kecamatantype extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatantype';

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
        'ID', 'date', 'name', 'nickname', 'summary', 'sortNum', 'image', 'entryDate', 'entryBy', 'entryIP', 'active'
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
        'ID' => 'int', 'date' => 'datetime', 'name' => 'string', 'nickname' => 'string', 'summary' => 'string', 'sortNum' => 'boolean', 'image' => 'string', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'entryDate'
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
