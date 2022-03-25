<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $memberID
 * @property string     $password
 * @property DateTime   $date
 * @property string     $name
 * @property string     $lastname
 * @property boolean    $sex
 * @property string     $email
 * @property string     $address
 * @property string     $city
 * @property string     $province
 * @property string     $postalCode
 * @property string     $country
 * @property string     $telephone
 * @property string     $fax
 * @property string     $mobile
 * @property Date       $dateofbirth
 * @property string     $businessName
 * @property string     $businessAddress
 * @property string     $businessDetail
 * @property string     $image
 * @property string     $website
 * @property string     $blog
 * @property string     $entryBy
 * @property string     $entryIP
 * @property DateTime   $approveDate
 * @property string     $approveBy
 * @property string     $approveIP
 * @property DateTime   $updateLast
 * @property string     $updateBy
 * @property string     $updateIP
 * @property int        $levelID
 * @property string     $accessScope
 * @property string     $remark
 * @property string     $random_key
 * @property boolean    $active
 */
class Members extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

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
        'ID', 'memberID', 'password', 'date', 'name', 'lastname', 'sex', 'email', 'address', 'city', 'province', 'postalCode', 'country', 'telephone', 'fax', 'mobile', 'dateofbirth', 'businessName', 'businessAddress', 'businessDetail', 'image', 'website', 'blog', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'levelID', 'accessScope', 'remark', 'random_key', 'active'
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
        'ID' => 'int', 'memberID' => 'string', 'password' => 'string', 'date' => 'datetime', 'name' => 'string', 'lastname' => 'string', 'sex' => 'boolean', 'email' => 'string', 'address' => 'string', 'city' => 'string', 'province' => 'string', 'postalCode' => 'string', 'country' => 'string', 'telephone' => 'string', 'fax' => 'string', 'mobile' => 'string', 'dateofbirth' => 'date', 'businessName' => 'string', 'businessAddress' => 'string', 'businessDetail' => 'string', 'image' => 'string', 'website' => 'string', 'blog' => 'string', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'levelID' => 'int', 'accessScope' => 'string', 'remark' => 'string', 'random_key' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'dateofbirth', 'approveDate', 'updateLast'
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
