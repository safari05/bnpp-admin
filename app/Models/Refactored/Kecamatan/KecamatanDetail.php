<?php

namespace App\Models\Refactored\Kecamatan;

use App\Models\Refactored\Utils\UtilsKecamatan;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $groupid
 * @property string     $code
 * @property string     $typeid
 * @property string     $lokpriid
 * @property int        $authorid
 * @property int        $jumlah_kk
 * @property int        $jumlah_penduduk
 */
class KecamatanDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_detail';

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
        'groupid', 'code', 'typeid', 'lokpriid', 'authorid', 'jumlah_kk', 'jumlah_penduduk'
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
        'groupid' => 'int', 'code' => 'string', 'typeid' => 'string', 'lokpriid' => 'string', 'authorid' => 'int', 'jumlah_kk' => 'int', 'jumlah_penduduk' => 'int'
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
    public function camat(){
        return $this->hasOne(KecamatanCamat::class, 'id', 'id');
    }

    public function aset(){
        return $this->hasMany(KecamatanAset::class, 'id', 'id');
    }

    public function mobilitas(){
        return $this->hasMany(KecamatanMobilitas::class, 'id', 'id');
    }

    public function coord(){
        return $this->hasOne(KecamatanCoord::class, 'id', 'id');
    }

    public function kepeg(){
        return $this->hasMany(KecamatanKepegawaian::class, 'id', 'id');
    }

    public function wilayah(){
        return $this->hasOne(KecamatanWilayah::class, 'id', 'id');
    }

    public function ppkt(){
        return $this->hasMany(KecamatanPpkt::class, 'id', 'id');
    }

    public function penduduk(){
        return $this->hasMany(KecamatanPenduduk::class, 'id', 'id');
    }
}
