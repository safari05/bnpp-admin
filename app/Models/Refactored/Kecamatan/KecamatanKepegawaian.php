<?php

namespace App\Models\Refactored\Kecamatan;

use App\Models\Refactored\Kepegawaian\KepegawaianJenisAsn;
use App\Models\Refactored\Kepegawaian\KepegawaianKelembagaan;
use App\Models\Refactored\Kepegawaian\KepegawaianOperasional;
use Illuminate\Database\Eloquent\Model;

/**
 * @property boolean    $jenis_asn
 * @property int        $operasional
 * @property int        $kelembagaan
 */
class KecamatanKepegawaian extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_kepegawaian';

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
        'id','jenis_asn', 'operasional', 'kelembagaan','jumlah'
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
        'jenis_asn' => 'int', 'operasional' => 'int', 'kelembagaan' => 'int'
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
    public function asn(){
        return $this->hasOne(KepegawaianJenisAsn::class, 'jenis_asn', 'jenis_asn');
    }

    public function staff_op(){
        return $this->hasOne(KepegawaianOperasional::class, 'idoperasional', 'operasional');
    }

    public function lembaga(){
        return $this->hasOne(KepegawaianKelembagaan::class, 'idkelembagaan', 'kelembagaan');
    }
}
