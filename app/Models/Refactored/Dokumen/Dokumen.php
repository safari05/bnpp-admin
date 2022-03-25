<?php

namespace App\Models\Refactored\Dokumen;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string     $nama
 * @property string     $file
 * @property int        $kategori
 * @property string     $tahun
 * @property DateTime   $created_at
 */
class Dokumen extends Model
{
    use SoftDeletes;

    public $timestamps = null;
    protected $table = 'dokumen';

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
        'nama', 'file', 'deskripsi', 'idkategori', 'tahun', 'ispublic', 'created_at', 'uploaded_by', 'validated', 'validated_by', 'deleted_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];
    // Relations ...

    public function kategori(){
        return $this->hasOne(DokumenKategori::class, 'idkategori', 'idkategori');
    }

    public function user(){
        return $this->hasOne(User::class, 'iduser', 'uploaded_by');
    }
}
