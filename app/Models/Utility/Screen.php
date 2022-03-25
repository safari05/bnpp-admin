<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $code
 * @property DateTime   $date
 * @property string     $name1
 * @property string     $name2
 * @property string     $summary1
 * @property string     $summary2
 * @property string     $content1
 * @property string     $content2
 * @property string     $mainContent
 * @property boolean    $mainContentType
 * @property string     $metaTitle
 * @property string     $tags
 * @property string     $h1
 * @property string     $h2
 * @property string     $sidebar1
 * @property string     $sidebar2
 * @property string     $sidebar3
 * @property string     $tableID
 * @property boolean    $styleID
 * @property string     $bannerID
 * @property string     $image
 * @property string     $imageLink
 * @property boolean    $navID
 * @property string     $parentID
 * @property int        $sortNum
 * @property boolean    $langID
 * @property string     $icon
 * @property string     $memberID
 * @property string     $entryBy
 * @property string     $entryIP
 * @property DateTime   $approveDate
 * @property string     $approveBy
 * @property string     $approveIP
 * @property DateTime   $updateLast
 * @property string     $updateBy
 * @property string     $updateIP
 * @property int        $hit
 * @property string     $remark
 * @property boolean    $active
 */
class Screen extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'screen';

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
        'ID', 'code', 'date', 'name1', 'name2', 'summary1', 'summary2', 'content1', 'content2', 'mainContent', 'mainContentType', 'metaTitle', 'tags', 'h1', 'h2', 'sidebar1', 'sidebar2', 'sidebar3', 'tableID', 'styleID', 'bannerID', 'image', 'imageLink', 'navID', 'parentID', 'sortNum', 'langID', 'icon', 'memberID', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'hit', 'remark', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'name1' => 'string', 'name2' => 'string', 'summary1' => 'string', 'summary2' => 'string', 'content1' => 'string', 'content2' => 'string', 'mainContent' => 'string', 'mainContentType' => 'boolean', 'metaTitle' => 'string', 'tags' => 'string', 'h1' => 'string', 'h2' => 'string', 'sidebar1' => 'string', 'sidebar2' => 'string', 'sidebar3' => 'string', 'tableID' => 'string', 'styleID' => 'boolean', 'bannerID' => 'string', 'image' => 'string', 'imageLink' => 'string', 'navID' => 'boolean', 'parentID' => 'string', 'sortNum' => 'int', 'langID' => 'boolean', 'icon' => 'string', 'memberID' => 'string', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'hit' => 'int', 'remark' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'approveDate', 'updateLast'
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
