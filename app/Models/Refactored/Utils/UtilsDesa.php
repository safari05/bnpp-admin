<?php

namespace App\Models\Refactored\Utils;

use App\Models\Refactored\Desa\DesaDetail;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $name
 */
class UtilsDesa extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'utils_desa';

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
        'kecamatanid', 'name','active'
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
    public function kecamatan(){
        return $this->hasOne(UtilsKecamatan::class, 'id', 'kecamatanid');
    }

    public function detail(){
        return $this->hasOne(DesaDetail::class, 'id', 'id');
    }
}
