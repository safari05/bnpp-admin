<?php

namespace App\Models\Wilayah;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $code
 * @property DateTime   $date
 * @property string     $name
 * @property int        $groupID
 * @property int        $provinsiID
 * @property int        $kabupatenkotaID
 * @property int        $kecamatanID
 * @property string     $summary
 * @property string     $tags
 * @property string     $content
 * @property Date       $lintasan_tanggal
 * @property string     $lintasan_no_identitas
 * @property string     $lintasan_barang_yang_di_bawa
 * @property string     $plb_nama
 * @property Date       $plb_tanggal
 * @property string     $pln_jenis_identitas
 * @property string     $plb_nomor_identitas
 * @property string     $pln_tipe_pendududuk
 * @property string     $plb_gender_pelintas
 * @property string     $plb_nama_pelintas
 * @property string     $plb_jenis_barang_01
 * @property string     $plb_nama_barang_01
 * @property string     $plb_jenis_barang_02
 * @property string     $plb_nama_barang_02
 * @property string     $plb_jenis_barang_03
 * @property string     $plb_nama_barang_03
 * @property string     $plb_jenis_barang_04
 * @property string     $plb_nama_barang_04
 * @property string     $plb_jenis_barang_05
 * @property string     $plb_nama_barang_05
 * @property int        $authorID
 * @property string     $image
 * @property string     $imageCaption
 * @property string     $file
 * @property string     $gallery
 * @property int        $sortNum
 * @property DateTime   $entryDate
 * @property string     $entryBy
 * @property string     $entryIP
 * @property DateTime   $approveDate
 * @property string     $approveBy
 * @property string     $approveIP
 * @property DateTime   $updateLast
 * @property string     $updateBy
 * @property string     $updateIP
 * @property boolean    $active
 */
class Lintasan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lintasan';

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
        'ID', 'code', 'date', 'name', 'groupID', 'provinsiID', 'kabupatenkotaID', 'kecamatanID', 'summary', 'tags', 'content', 'lintasan_tanggal', 'lintasan_no_identitas', 'lintasan_barang_yang_di_bawa', 'plb_nama', 'plb_tanggal', 'pln_jam', 'pln_jenis_identitas', 'plb_nomor_identitas', 'pln_tipe_pendududuk', 'plb_gender_pelintas', 'plb_nama_pelintas', 'plb_jenis_barang_01', 'plb_nama_barang_01', 'plb_jenis_barang_02', 'plb_nama_barang_02', 'plb_jenis_barang_03', 'plb_nama_barang_03', 'plb_jenis_barang_04', 'plb_nama_barang_04', 'plb_jenis_barang_05', 'plb_nama_barang_05', 'authorID', 'image', 'imageCaption', 'file', 'gallery', 'sortNum', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'name' => 'string', 'groupID' => 'int', 'provinsiID' => 'int', 'kabupatenkotaID' => 'int', 'kecamatanID' => 'int', 'summary' => 'string', 'tags' => 'string', 'content' => 'string', 'lintasan_tanggal' => 'date', 'lintasan_no_identitas' => 'string', 'lintasan_barang_yang_di_bawa' => 'string', 'plb_nama' => 'string', 'plb_tanggal' => 'date', 'pln_jenis_identitas' => 'string', 'plb_nomor_identitas' => 'string', 'pln_tipe_pendududuk' => 'string', 'plb_gender_pelintas' => 'string', 'plb_nama_pelintas' => 'string', 'plb_jenis_barang_01' => 'string', 'plb_nama_barang_01' => 'string', 'plb_jenis_barang_02' => 'string', 'plb_nama_barang_02' => 'string', 'plb_jenis_barang_03' => 'string', 'plb_nama_barang_03' => 'string', 'plb_jenis_barang_04' => 'string', 'plb_nama_barang_04' => 'string', 'plb_jenis_barang_05' => 'string', 'plb_nama_barang_05' => 'string', 'authorID' => 'int', 'image' => 'string', 'imageCaption' => 'string', 'file' => 'string', 'gallery' => 'string', 'sortNum' => 'int', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'lintasan_tanggal', 'plb_tanggal', 'entryDate', 'approveDate', 'updateLast'
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
