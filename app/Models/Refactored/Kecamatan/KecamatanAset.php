<?php

namespace App\Models\Refactored\Kecamatan;

use App\Models\Refactored\Master\AsetItem;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $iditem
 * @property int        $provinsiid
 * @property int        $kabupatenkotaid
 * @property int        $jumlah_baik
 * @property int        $jumlah_rusak
 */
class KecamatanAset extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_aset';

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
        'iditem', 'kecamatanid', 'provinsiid', 'kabupatenkotaid', 'jumlah_baik', 'jumlah_rusak'
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
        'id'=>'int', 'iditem'=>'int', 'jumlah_baik' => 'int', 'jumlah_rusak' => 'int'
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
    public function item(){
        return $this->hasOne(AsetItem::class, 'iditem', 'iditem');
    }
}
