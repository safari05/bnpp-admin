<?php

namespace App\Models\Refactored\Konten;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idcategory
 * @property string     $nama
 */
class ContentCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_category';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idcategory';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idcategory', 'nama'
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
        'idcategory' => 'int', 'nama' => 'string'
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
    public function content(){
        return $this->hasMany(Content::class, 'idkategori', 'idcategory');
    }
}
