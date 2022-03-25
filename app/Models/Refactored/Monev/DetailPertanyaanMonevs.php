<?php

namespace App\Models\Refactored\Monev;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $bobot_ketersediaan
 * @property int        $bobot_kecukupan
 * @property int        $kondisi
 * @property int        $bobot_kondisi
 * @property int        $kebutuhan
 * @property int        $keterisian
 * @property int        $bobot_keb_ket
 * @property int        $bobot_nilai_pendidikan
 * @property int        $banyak_pendidikan
 * @property int        $jum_bobot_nilai_pendidikan
 * @property int        $created_at
 * @property int        $updated_at
 */
class DetailPertanyaanMonevs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_pertanyaan_monevs';

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
        'detail_monev_id', 'pertanyaan_id', 'ketersediaan', 'bobot_ketersediaan', 'kecukupan', 'bobot_kecukupan', 'kondisi', 'bobot_kondisi', 'kebutuhan', 'keterisian', 'bobot_keb_ket', 'bobot_nilai_pendidikan', 'banyak_pendidikan', 'jum_bobot_nilai_pendidikan', 'created_at', 'updated_at'
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
        'bobot_ketersediaan' => 'int', 'bobot_kecukupan' => 'int', 'kondisi' => 'int', 'bobot_kondisi' => 'int', 'kebutuhan' => 'int', 'keterisian' => 'int', 'bobot_keb_ket' => 'int', 'bobot_nilai_pendidikan' => 'int', 'banyak_pendidikan' => 'int', 'jum_bobot_nilai_pendidikan' => 'int', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
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
    public function detail(){
        return $this->belongsTo(DetailMonevs::class, 'id', 'detail_monev_id');
    }

    public function pertanyaan(){
        return $this->hasOne(Pertanyaans::class, 'id', 'pertanyaan_id');
    }
}
