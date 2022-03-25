<?php

namespace App\Models\Kecamatan;

use App\Models\Wilayah\Kabupatenkota;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $code
 * @property DateTime   $date
 * @property string     $name
 * @property int        $groupID
 * @property int        $provinsiID
 * @property int        $kabupatenkotaID
 * @property string     $typeID
 * @property string     $lokpriID
 * @property string     $summary
 * @property string     $tags
 * @property string     $content
 * @property string     $adm_luas_wilayah
 * @property string     $adm_jumlah_KK
 * @property string     $adm_jumlah_penduduk
 * @property string     $adm_jumlah_penduduk_pria
 * @property string     $adm_jumlah_penduduk_wanita
 * @property int        $adm_jumlah_penduduk_u0
 * @property int        $adm_jumlah_penduduk_u5
 * @property int        $adm_jumlah_penduduk_u10
 * @property int        $adm_jumlah_penduduk_u15
 * @property int        $adm_jumlah_penduduk_u20
 * @property int        $adm_jumlah_penduduk_u25
 * @property int        $adm_jumlah_penduduk_u30
 * @property int        $adm_jumlah_penduduk_u35
 * @property int        $adm_jumlah_penduduk_u40
 * @property int        $adm_jumlah_penduduk_u45
 * @property int        $adm_jumlah_penduduk_u50
 * @property int        $adm_jumlah_penduduk_u55
 * @property int        $adm_jumlah_penduduk_u60
 * @property int        $adm_jumlah_penduduk_u65
 * @property int        $adm_jumlah_penduduk_u70
 * @property int        $adm_jumlah_penduduk_u75
 * @property string     $adm_ibukota_kecamatan
 * @property string     $adm_gender_camat
 * @property string     $adm_nama_camat
 * @property string     $adm_pendidikan_camat
 * @property string     $adm_alamat_kecamatan
 * @property string     $adm_kodepos_kecamatan
 * @property string     $adm_regulasi_kecamatan
 * @property int        $adm_jumlah_desa
 * @property int        $adm_jumlah_kelurahan
 * @property string     $adm_jumlah_pulau
 * @property string     $adm_jumlah_PPKT
 * @property string     $adm_nama_PPKT_Berpenduduk
 * @property string     $adm_nama_PPKT_Tidak_Berpenduduk
 * @property string     $adm_batas_kecamatan_barat
 * @property string     $adm_batas_kecamatan_timur
 * @property string     $adm_batas_kecamatan_utara
 * @property string     $adm_batas_kecamatan_selatan
 * @property string     $adm_batas_negara_jenis
 * @property string     $adm_batas_negara_nama
 * @property string     $adm_jarak_ibukota_ke_provinsi
 * @property string     $adm_jarak_ibukota_ke_kabupaten
 * @property string     $adm_peta
 * @property string     $sarpras_kantor_camat_status
 * @property string     $sarpras_kantor_camat_kondisi
 * @property string     $sarpras_kantor_camat_foto
 * @property string     $sarpras_balai_status
 * @property string     $sarpras_balai_kondisi
 * @property string     $sarpras_balai_foto
 * @property int        $sarpras_aset_meja_baik
 * @property int        $sarpras_aset_meja_rusak
 * @property int        $sarpras_aset_kursi_baik
 * @property int        $sarpras_aset_kursi_rusak
 * @property int        $sarpras_aset_lemari_baik
 * @property int        $sarpras_aset_lemari_rusak
 * @property int        $sarpras_aset_mesin_tik_baik
 * @property int        $sarpras_aset_mesin_tik_rusak
 * @property int        $sarpras_aset_komputer_baik
 * @property int        $sarpras_aset_komputer_rusak
 * @property int        $sarpras_aset_printer_baik
 * @property int        $sarpras_aset_printer_rusak
 * @property string     $sarpras_mobilitas_jumlah_mobil
 * @property string     $sarpras_mobilitas_jumlah_motor
 * @property string     $sarpras_mobilitas_jumlah_speedboat
 * @property string     $sarpras_mobilitas_foto
 * @property int        $sdm_ASN
 * @property int        $sdm_non_ASN
 * @property int        $sdm_jumlah
 * @property string     $so_sekretaris
 * @property string     $so_pemerintahan
 * @property string     $so_kesejahteraan
 * @property string     $so_pelayanan
 * @property string     $so_keuangan
 * @property string     $so_perencanaan
 * @property string     $so_tata_usaha
 * @property string     $so_trantib
 * @property string     $kelembagaan_paten
 * @property string     $kelembagaan_UPT_dukcapil
 * @property string     $plb_status
 * @property string     $plb_nama
 * @property string     $kelembagaan_imigrasi
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
class Kecamatan extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kecamatan';

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
        'ID', 'code', 'date', 'name', 'groupID', 'provinsiID', 'kabupatenkotaID', 'typeID', 'lokpriID', 'summary', 'tags', 'content', 'adm_luas_wilayah', 'adm_jumlah_KK', 'adm_jumlah_penduduk', 'adm_jumlah_penduduk_pria', 'adm_jumlah_penduduk_wanita', 'adm_jumlah_penduduk_u0', 'adm_jumlah_penduduk_u5', 'adm_jumlah_penduduk_u10', 'adm_jumlah_penduduk_u15', 'adm_jumlah_penduduk_u20', 'adm_jumlah_penduduk_u25', 'adm_jumlah_penduduk_u30', 'adm_jumlah_penduduk_u35', 'adm_jumlah_penduduk_u40', 'adm_jumlah_penduduk_u45', 'adm_jumlah_penduduk_u50', 'adm_jumlah_penduduk_u55', 'adm_jumlah_penduduk_u60', 'adm_jumlah_penduduk_u65', 'adm_jumlah_penduduk_u70', 'adm_jumlah_penduduk_u75', 'adm_ibukota_kecamatan', 'adm_gender_camat', 'adm_nama_camat', 'adm_pendidikan_camat', 'adm_alamat_kecamatan', 'adm_kodepos_kecamatan', 'adm_regulasi_kecamatan', 'adm_jumlah_desa', 'adm_jumlah_kelurahan', 'adm_jumlah_pulau', 'adm_jumlah_PPKT', 'adm_nama_PPKT_Berpenduduk', 'adm_nama_PPKT_Tidak_Berpenduduk', 'adm_batas_kecamatan_barat', 'adm_batas_kecamatan_timur', 'adm_batas_kecamatan_utara', 'adm_batas_kecamatan_selatan', 'adm_batas_negara_jenis', 'adm_batas_negara_nama', 'adm_jarak_ibukota_ke_provinsi', 'adm_jarak_ibukota_ke_kabupaten', 'adm_peta', 'sarpras_kantor_camat_status', 'sarpras_kantor_camat_kondisi', 'sarpras_kantor_camat_foto', 'sarpras_balai_status', 'sarpras_balai_kondisi', 'sarpras_balai_foto', 'sarpras_aset_meja_baik', 'sarpras_aset_meja_rusak', 'sarpras_aset_kursi_baik', 'sarpras_aset_kursi_rusak', 'sarpras_aset_lemari_baik', 'sarpras_aset_lemari_rusak', 'sarpras_aset_mesin_tik_baik', 'sarpras_aset_mesin_tik_rusak', 'sarpras_aset_komputer_baik', 'sarpras_aset_komputer_rusak', 'sarpras_aset_printer_baik', 'sarpras_aset_printer_rusak', 'sarpras_mobilitas_jumlah_mobil', 'sarpras_mobilitas_jumlah_motor', 'sarpras_mobilitas_jumlah_speedboat', 'sarpras_mobilitas_foto', 'sdm_ASN', 'sdm_non_ASN', 'sdm_jumlah', 'so_sekretaris', 'so_pemerintahan', 'so_kesejahteraan', 'so_pelayanan', 'so_keuangan', 'so_perencanaan', 'so_tata_usaha', 'so_trantib', 'kelembagaan_paten', 'kelembagaan_UPT_dukcapil', 'plb_status', 'plb_nama', 'kelembagaan_imigrasi', 'authorID', 'image', 'imageCaption', 'file', 'gallery', 'sortNum', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'name' => 'string', 'groupID' => 'int', 'provinsiID' => 'int', 'kabupatenkotaID' => 'int', 'typeID' => 'string', 'lokpriID' => 'string', 'summary' => 'string', 'tags' => 'string', 'content' => 'string', 'adm_luas_wilayah' => 'string', 'adm_jumlah_KK' => 'string', 'adm_jumlah_penduduk' => 'string', 'adm_jumlah_penduduk_pria' => 'string', 'adm_jumlah_penduduk_wanita' => 'string', 'adm_jumlah_penduduk_u0' => 'int', 'adm_jumlah_penduduk_u5' => 'int', 'adm_jumlah_penduduk_u10' => 'int', 'adm_jumlah_penduduk_u15' => 'int', 'adm_jumlah_penduduk_u20' => 'int', 'adm_jumlah_penduduk_u25' => 'int', 'adm_jumlah_penduduk_u30' => 'int', 'adm_jumlah_penduduk_u35' => 'int', 'adm_jumlah_penduduk_u40' => 'int', 'adm_jumlah_penduduk_u45' => 'int', 'adm_jumlah_penduduk_u50' => 'int', 'adm_jumlah_penduduk_u55' => 'int', 'adm_jumlah_penduduk_u60' => 'int', 'adm_jumlah_penduduk_u65' => 'int', 'adm_jumlah_penduduk_u70' => 'int', 'adm_jumlah_penduduk_u75' => 'int', 'adm_ibukota_kecamatan' => 'string', 'adm_gender_camat' => 'string', 'adm_nama_camat' => 'string', 'adm_pendidikan_camat' => 'string', 'adm_alamat_kecamatan' => 'string', 'adm_kodepos_kecamatan' => 'string', 'adm_regulasi_kecamatan' => 'string', 'adm_jumlah_desa' => 'int', 'adm_jumlah_kelurahan' => 'int', 'adm_jumlah_pulau' => 'string', 'adm_jumlah_PPKT' => 'string', 'adm_nama_PPKT_Berpenduduk' => 'string', 'adm_nama_PPKT_Tidak_Berpenduduk' => 'string', 'adm_batas_kecamatan_barat' => 'string', 'adm_batas_kecamatan_timur' => 'string', 'adm_batas_kecamatan_utara' => 'string', 'adm_batas_kecamatan_selatan' => 'string', 'adm_batas_negara_jenis' => 'string', 'adm_batas_negara_nama' => 'string', 'adm_jarak_ibukota_ke_provinsi' => 'string', 'adm_jarak_ibukota_ke_kabupaten' => 'string', 'adm_peta' => 'string', 'sarpras_kantor_camat_status' => 'string', 'sarpras_kantor_camat_kondisi' => 'string', 'sarpras_kantor_camat_foto' => 'string', 'sarpras_balai_status' => 'string', 'sarpras_balai_kondisi' => 'string', 'sarpras_balai_foto' => 'string', 'sarpras_aset_meja_baik' => 'int', 'sarpras_aset_meja_rusak' => 'int', 'sarpras_aset_kursi_baik' => 'int', 'sarpras_aset_kursi_rusak' => 'int', 'sarpras_aset_lemari_baik' => 'int', 'sarpras_aset_lemari_rusak' => 'int', 'sarpras_aset_mesin_tik_baik' => 'int', 'sarpras_aset_mesin_tik_rusak' => 'int', 'sarpras_aset_komputer_baik' => 'int', 'sarpras_aset_komputer_rusak' => 'int', 'sarpras_aset_printer_baik' => 'int', 'sarpras_aset_printer_rusak' => 'int', 'sarpras_mobilitas_jumlah_mobil' => 'string', 'sarpras_mobilitas_jumlah_motor' => 'string', 'sarpras_mobilitas_jumlah_speedboat' => 'string', 'sarpras_mobilitas_foto' => 'string', 'sdm_ASN' => 'int', 'sdm_non_ASN' => 'int', 'sdm_jumlah' => 'int', 'so_sekretaris' => 'string', 'so_pemerintahan' => 'string', 'so_kesejahteraan' => 'string', 'so_pelayanan' => 'string', 'so_keuangan' => 'string', 'so_perencanaan' => 'string', 'so_tata_usaha' => 'string', 'so_trantib' => 'string', 'kelembagaan_paten' => 'string', 'kelembagaan_UPT_dukcapil' => 'string', 'plb_status' => 'string', 'plb_nama' => 'string', 'kelembagaan_imigrasi' => 'string', 'authorID' => 'int', 'image' => 'string', 'imageCaption' => 'string', 'file' => 'string', 'gallery' => 'string', 'sortNum' => 'int', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'active' => 'boolean'
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

    public function kota(){
        return $this->hasOne(Kabupatenkota::class, ['provinsiID', 'ID'], ['provinsiID', 'kabupatenkotaID']);
    }

}
