<?php

namespace App\Models\Refactored\Monev;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $nama
 * @property string     $type
 * @property int        $created_at
 * @property int        $updated_at
 */
class Indikators extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'indikators';

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
        'nama', 'type', 'variabel_id', 'created_at', 'updated_at'
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
        'nama' => 'string', 'type' => 'string', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
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
    public function variabel(){
        return $this->hasOne(Variabels::class, 'id', 'variabel_id');
    }
}
