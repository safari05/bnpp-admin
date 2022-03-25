<?php

namespace App\Models\Refactored\Utils;

use App\Models\Refactored\Kecamatan\KecamatanDetail;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $name
 */
class UtilsKecamatan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'utils_kecamatan';

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
        'kotaid', 'name','active'
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
        'name' => 'string'
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
    public function kota(){
        return $this->hasOne(UtilsKota::class, 'id', 'kotaid');
    }

    public function desa(){
        return $this->hasMany(UtilsDesa::class, 'kecamatanid', 'id');
    }

    public function detail(){
        return $this->hasOne(KecamatanDetail::class, 'id', 'id');
    }
}
