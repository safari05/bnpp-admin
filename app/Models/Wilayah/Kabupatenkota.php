<?php

namespace App\Models\Wilayah;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property DateTime   $date
 * @property string     $name
 * @property int        $provinsiID
 * @property int        $sortNum
 * @property string     $image
 * @property DateTime   $entryDate
 * @property string     $entryBy
 * @property string     $entryIP
 * @property boolean    $status
 * @property boolean    $active
 */
class Kabupatenkota extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kabupatenkota';

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
        'ID', 'date', 'name', 'provinsiID', 'sortNum', 'image', 'entryDate', 'entryBy', 'entryIP', 'status', 'active'
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
        'ID' => 'int', 'date' => 'datetime', 'name' => 'string', 'provinsiID' => 'int', 'sortNum' => 'int', 'image' => 'string', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'status' => 'boolean', 'active' => 'boolean'
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

    public function provinsi(){
        return $this->hasOne(Provinsi::class, 'ID', 'provinsiID');
    }
}
