<?php

namespace App\Models\Refactored\Desa;

use App\Models\Refactored\Utils\UtilsDesa;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $name
 * @property int        $groupid
 * @property string     $code
 * @property int        $jumlah_kk
 * @property int        $jumlah_penduduk
 */
class DesaDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desa_detail';

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
        'id','name', 'groupid', 'code', 'jumlah_kk', 'jumlah_penduduk'
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
        'name' => 'string', 'groupid' => 'int', 'code' => 'string', 'jumlah_kk' => 'int', 'jumlah_penduduk' => 'int'
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
    public function aset(){
        return $this->hasMany(DesaAset::class, 'id', 'id');
    }

    public function coord(){
        return $this->hasOne(DesaCoord::class, 'id', 'id');
    }

    public function kades(){
        return $this->hasOne(DesaKades::class, 'id', 'id');
    }

    public function kepeg(){
        return $this->hasMany(DesaKepegawaian::class, 'id', 'id');
    }

    public function mobil(){
        return $this->hasMany(DesaMobilitas::class, 'id', 'id');
    }

    public function sipil(){
        return $this->hasMany(DesaPenduduk::class, 'id', 'id');
    }

    public function pondes(){
        return $this->hasMany(DesaPondes::class, 'id', 'id');
    }

    public function wilayah(){
        return $this->hasOne(DesaWilayah::class, 'id', 'id');
    }
}
