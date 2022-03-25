<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $code
 * @property DateTime   $date
 * @property string     $name
 * @property int        $provinsiID
 * @property int        $kabupatenkotaID
 * @property int        $kecamatanID
 * @property int        $desakelurahanID
 * @property string     $summary
 * @property string     $tags
 * @property string     $content
 * @property string     $plb_nama
 * @property string     $pln_jenis
 * @property string     $plb_tipe
 * @property string     $status_imigrasi
 * @property string     $status_karantina_kesehatan
 * @property string     $status_karantina_pertanian
 * @property string     $status_karantina_perikanan
 * @property string     $status_keamanan_tni
 * @property string     $status_keamanan_polri
 * @property string     $jenis_perbatasan
 * @property int        $batas_negara_timur
 * @property string     $batas_negara_barat
 * @property string     $batas_negara_utara
 * @property string     $batas_negara_selatan
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
class Plb extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plb';

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
        'ID', 'code', 'date', 'name', 'provinsiID', 'kabupatenkotaID', 'kecamatanID', 'desakelurahanID', 'summary', 'tags', 'content', 'plb_nama', 'pln_jenis', 'plb_tipe', 'status_imigrasi', 'status_karantina_kesehatan', 'status_karantina_pertanian', 'status_karantina_perikanan', 'status_keamanan_tni', 'status_keamanan_polri', 'jenis_perbatasan', 'batas_negara_timur', 'batas_negara_barat', 'batas_negara_utara', 'batas_negara_selatan', 'authorID', 'image', 'imageCaption', 'file', 'gallery', 'sortNum', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'name' => 'string', 'provinsiID' => 'int', 'kabupatenkotaID' => 'int', 'kecamatanID' => 'int', 'desakelurahanID' => 'int', 'summary' => 'string', 'tags' => 'string', 'content' => 'string', 'plb_nama' => 'string', 'pln_jenis' => 'string', 'plb_tipe' => 'string', 'status_imigrasi' => 'string', 'status_karantina_kesehatan' => 'string', 'status_karantina_pertanian' => 'string', 'status_karantina_perikanan' => 'string', 'status_keamanan_tni' => 'string', 'status_keamanan_polri' => 'string', 'jenis_perbatasan' => 'string', 'batas_negara_timur' => 'int', 'batas_negara_barat' => 'string', 'batas_negara_utara' => 'string', 'batas_negara_selatan' => 'string', 'authorID' => 'int', 'image' => 'string', 'imageCaption' => 'string', 'file' => 'string', 'gallery' => 'string', 'sortNum' => 'int', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'entryDate', 'approveDate', 'updateLast'
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
