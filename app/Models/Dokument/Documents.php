<?php

namespace App\Models\Dokument;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $code
 * @property DateTime   $date
 * @property string     $title
 * @property string     $image
 * @property string     $file
 * @property int        $categoryID
 * @property string     $tahun
 * @property int        $sortNum
 * @property string     $memberID
 * @property DateTime   $entryDate
 * @property string     $entryBy
 * @property string     $entryIP
 * @property DateTime   $approveDate
 * @property string     $approveBy
 * @property string     $approveIP
 * @property DateTime   $updateLast
 * @property string     $updateBy
 * @property string     $updateIP
 * @property string     $remark
 * @property boolean    $active
 */
class Documents extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

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
        'ID', 'code', 'date', 'title', 'image', 'file', 'categoryID', 'tahun', 'sortNum', 'memberID', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'remark', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'title' => 'string', 'image' => 'string', 'file' => 'string', 'categoryID' => 'int', 'tahun' => 'string', 'sortNum' => 'int', 'memberID' => 'string', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'remark' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'entryDate', 'approveDate', 'updateLast'
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
