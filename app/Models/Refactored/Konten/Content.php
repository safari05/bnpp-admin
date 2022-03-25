<?php

namespace App\Models\Refactored\Konten;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int        $idcontent
 * @property int        $idauthor
 * @property string     $judul
 * @property string     $content
 * @property DateTime   $created_at
 * @property DateTime   $updated_at
 * @property string     $slug
 * @property boolean    $status
 * @property int        $idkategori
 */
class Content extends Model
{
    use SoftDeletes;
    protected $table = 'content';
    protected $primaryKey = 'idcontent';
    protected $fillable = [
        'idcontent', 'idauthor', 'judul', 'poster','content', 'created_at', 'updated_at', 'slug', 'status', 'idkategori'
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
    public function kategori(){
        return $this->hasOne(ContentCategory::class, 'idcategory', 'idkategori');
    }

    public function author(){
        return $this->hasOne(User::class, 'iduser', 'idauthor');
    }
}
