<?php

namespace App\Models\Refactored\PLB;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idplb
 * @property int        $idlintas
 * @property int        $idbarang
 * @property string     $jenis_barang
 * @property string     $nama_barang
 * @property int        $jumlah_barang
 * @property string     $satuan_jumlah_barang
 */
class PlbLogLintasanBarang extends Model
{
    use Compoships;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plb_log_lintasan_barang';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idbarang';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idplb', 'idlintas', 'idbarang', 'jenis_barang', 'nama_barang', 'jumlah_barang', 'satuan_jumlah_barang'
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
        'idplb' => 'int', 'idlintas' => 'int', 'idbarang' => 'int', 'jenis_barang' => 'string', 'nama_barang' => 'string', 'jumlah_barang' => 'int', 'satuan_jumlah_barang' => 'string'
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
    public function jenis(){
        return $this->hasOne(PlbLogLintasanJenisBarang::class, 'idjenis', 'idjenis');
    }
}
