<?php

namespace App\Models\Refactored\Desa;

use App\Models\Refactored\Master\PendudukJenis;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idjenis
 * @property int        $jumlah
 */
class DesaPenduduk extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desa_penduduk';

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
        'idjenis', 'jumlah'
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
        'idjenis' => 'int', 'jumlah' => 'int'
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
        return $this->hasOne(PendudukJenis::class, 'idjenis', 'idjenis');
    }
}
