<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $code
 * @property DateTime   $date
 * @property DateTime   $publishDate
 * @property string     $header1
 * @property string     $header2
 * @property string     $summary1
 * @property string     $summary2
 * @property string     $tags
 * @property string     $content1
 * @property string     $content2
 * @property int        $categoryID
 * @property int        $authorID
 * @property string     $image
 * @property string     $imageCaption
 * @property string     $file
 * @property string     $gallery
 * @property DateTime   $entryDate
 * @property string     $entryBy
 * @property string     $entryIP
 * @property DateTime   $approveDate
 * @property string     $approveBy
 * @property string     $approveIP
 * @property DateTime   $updateLast
 * @property string     $updateBy
 * @property string     $updateIP
 * @property boolean    $active
 */
class News extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news';

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
        'ID', 'code', 'date', 'publishDate', 'header1', 'header2', 'summary1', 'summary2', 'tags', 'content1', 'content2', 'categoryID', 'authorID', 'image', 'imageCaption', 'file', 'gallery', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'publishDate' => 'datetime', 'header1' => 'string', 'header2' => 'string', 'summary1' => 'string', 'summary2' => 'string', 'tags' => 'string', 'content1' => 'string', 'content2' => 'string', 'categoryID' => 'int', 'authorID' => 'int', 'image' => 'string', 'imageCaption' => 'string', 'file' => 'string', 'gallery' => 'string', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'publishDate', 'entryDate', 'approveDate', 'updateLast'
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
