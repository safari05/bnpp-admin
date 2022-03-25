<?php

namespace App\Models\Refactored\Dokumen;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $idkategori
 * @property string     $keterangan
 */
class DokumenKategori extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dokumen_kategori';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idkategori';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idkategori', 'keterangan'
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
        'idkategori' => 'int', 'keterangan' => 'string'
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
}
