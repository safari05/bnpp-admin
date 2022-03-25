<?php

namespace App\Models\Refactored\PLB;

use App\Models\Refactored\Plb\Plb;
use App\Models\Refactored\Plb\PlbLintasanBarang;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int        $idplb
 * @property int        $idlintas
 * @property Date       $tanggal_lintas
 * @property string     $jenis_identitas
 * @property string     $nomor_identitas
 * @property string     $nama_pelintas
 * @property boolean    $tipe_penduduk_pelintas
 */
class PlbLogLintasan extends Model
{
    use Compoships, SoftDeletes;
    protected $table = 'plb_log_lintasan';
    protected $primaryKey = 'idlintas';
    protected $fillable = [
        'idplb', 'idlintas', 'tanggal_lintas', 'jam_lintas', 'jenis_identitas', 'nomor_identitas', 'nama_pelintas', 'gender_pelintas', 'tipe_penduduk_pelintas', 'deleted_at'
    ];
    public $timestamps = false;
    public function barang(){
        return $this->hasMany(PlbLogLintasanBarang::class, ['idplb','idlintas'], ['idplb','idlintas']);
    }

    public function orang(){
        return $this->hasMany(PlbLogLintasanOrang::class, ['idplb','idlintas'], ['idplb','idlintas']);
    }

    public function plb(){
        return $this->hasOne(Plb::class, 'idplb', 'idplb');
    }
}
