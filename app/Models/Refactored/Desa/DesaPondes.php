<?php

namespace App\Models\Refactored\Desa;

use App\Models\Refactored\Master\PondesJenis;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $jenis_pondes
 * @property int        $jumlah
 */
class DesaPondes extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desa_pondes';

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
        'jenis_pondes', 'jumlah'
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
        'jenis_pondes' => 'int', 'jumlah' => 'int'
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
        return $this->hasOne(PondesJenis::class, 'idjenis', 'jenis_pondes');
    }
}
