<?php

namespace App\Models\Refactored\Kecamatan;

use App\Models\Refactored\Master\MobilitasItem;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idmobilitas
 * @property int        $jumlah
 * @property string     $foto
 */
class KecamatanMobilitas extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan_mobilitas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idmobilitas';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'idmobilitas', 'jumlah', 'foto'
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
        'idmobilitas' => 'int', 'jumlah' => 'int', 'foto' => 'string'
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
        return $this->hasOne(MobilitasItem::class, 'idmobilitas', 'idmobilitas');
    }
}
