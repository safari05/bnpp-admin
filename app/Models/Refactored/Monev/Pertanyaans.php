<?php

namespace App\Models\Refactored\Monev;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $pertanyaan
 * @property int        $bobot_default
 * @property boolean    $lokpri_batas_darat
 * @property boolean    $lokpri_batas_laut
 * @property boolean    $lokpri_pksn_darat
 * @property boolean    $lokpri_pksn_laut
 * @property boolean    $lokpri_ppkt
 * @property int        $created_at
 * @property int        $updated_at
 */
class Pertanyaans extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pertanyaans';

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
        'pertanyaan', 'bobot_default', 'lokpri_batas_darat', 'lokpri_batas_laut', 'lokpri_pksn_darat', 'lokpri_pksn_laut', 'lokpri_ppkt', 'indikator_id', 'created_at', 'updated_at'
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
        'pertanyaan' => 'string', 'bobot_default' => 'int', 'lokpri_batas_darat' => 'boolean', 'lokpri_batas_laut' => 'boolean', 'lokpri_pksn_darat' => 'boolean', 'lokpri_pksn_laut' => 'boolean', 'lokpri_ppkt' => 'boolean', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
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
    public function indikator(){
        return $this->hasOne(Indikators::class, 'id', 'indikator_id');
    }
}
