<?php

namespace App\Models\Desa;

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
 * @property string     $adm_luas_wilayah
 * @property string     $adm_jumlah_KK
 * @property string     $adm_jumlah_penduduk
 * @property string     $adm_jumlah_penduduk_pria
 * @property string     $adm_jumlah_penduduk_wanita
 * @property int        $adm_jumlah_penduduk_U0
 * @property int        $adm_jumlah_penduduk_U5
 * @property int        $adm_jumlah_penduduk_U10
 * @property int        $adm_jumlah_penduduk_U15
 * @property int        $adm_jumlah_penduduk_U20
 * @property int        $adm_jumlah_penduduk_U25
 * @property int        $adm_jumlah_penduduk_U30
 * @property int        $adm_jumlah_penduduk_U35
 * @property int        $adm_jumlah_penduduk_U40
 * @property int        $adm_jumlah_penduduk_U45
 * @property int        $adm_jumlah_penduduk_U50
 * @property int        $adm_jumlah_penduduk_U55
 * @property int        $adm_jumlah_penduduk_U60
 * @property int        $adm_jumlah_penduduk_U65
 * @property int        $adm_jumlah_penduduk_U70
 * @property int        $adm_jumlah_penduduk_U75
 * @property string     $adm_ibukota_desa
 * @property string     $adm_gender_kades
 * @property string     $adm_nama_kades
 * @property string     $adm_pendidikan_kades
 * @property string     $adm_alamat_desa
 * @property string     $adm_kodepos_desa
 * @property string     $adm_regulasi_desa
 * @property string     $adm_batas_desa_barat
 * @property string     $adm_batas_desa_timur
 * @property string     $adm_batas_desa_utara
 * @property string     $adm_batas_desa_selatan
 * @property string     $adm_batas_desa_peta
 * @property string     $adm_batas_negara_jenis
 * @property string     $adm_batas_negara_nama
 * @property string     $adm_jarak_desa_ke_kabupaten
 * @property string     $adm_jarak_desa_ke_kecamatan
 * @property string     $adm_foto
 * @property string     $sarpras_kantor_desa_status
 * @property string     $sarpras_kantor_desa_kondisi
 * @property string     $sarpras_kantor_desa_foto
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
 * @property string     $so_teknis
 * @property string     $so_kewilayahan
 * @property string     $so_lainnya
 * @property string     $plb_status
 * @property string     $plb_nama
 * @property string     $pondes_BPD
 * @property int        $pondes_jumlah_anggota_BPD
 * @property string     $pondes_pangan
 * @property string     $pondes_non_pangan
 * @property int        $pondes_jumlah_RS
 * @property int        $pondes_jumlah_RSB
 * @property int        $pondes_jumlah_puskesmas_inap
 * @property int        $pondes_jumlah_puskesmas
 * @property int        $pondes_jumlah_posyandu
 * @property int        $pondes_JAMKESDA
 * @property int        $pondes_SKTM
 * @property int        $pondes_PKK
 * @property int        $pondes_karang_taruna
 * @property int        $pondes_lembaga_adat
 * @property int        $pondes_kelompok_tani
 * @property int        $pondes_kelompok_masyarakat
 * @property string     $pondes_kantor_pos
 * @property int        $pondes_industri_kecil
 * @property int        $pondes_KUD
 * @property int        $pondes_KOSPIN
 * @property int        $pondes_koperasi_lainnya
 * @property int        $pondes_pasar_permanen
 * @property int        $pondes_pasar_semi
 * @property int        $pondes_pasar_kaget
 * @property int        $pondes_bank_pemerintah
 * @property int        $pondes_bank_swasta
 * @property int        $pondes_pengadaian
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
class Desakelurahan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desakelurahan';

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
        'ID', 'code', 'date', 'name', 'groupID', 'provinsiID', 'kabupatenkotaID', 'kecamatanID', 'summary', 'tags', 'content', 'adm_luas_wilayah', 'adm_jumlah_KK', 'adm_jumlah_penduduk', 'adm_jumlah_penduduk_pria', 'adm_jumlah_penduduk_wanita', 'adm_jumlah_penduduk_U0', 'adm_jumlah_penduduk_U5', 'adm_jumlah_penduduk_U10', 'adm_jumlah_penduduk_U15', 'adm_jumlah_penduduk_U20', 'adm_jumlah_penduduk_U25', 'adm_jumlah_penduduk_U30', 'adm_jumlah_penduduk_U35', 'adm_jumlah_penduduk_U40', 'adm_jumlah_penduduk_U45', 'adm_jumlah_penduduk_U50', 'adm_jumlah_penduduk_U55', 'adm_jumlah_penduduk_U60', 'adm_jumlah_penduduk_U65', 'adm_jumlah_penduduk_U70', 'adm_jumlah_penduduk_U75', 'adm_ibukota_desa', 'adm_gender_kades', 'adm_nama_kades', 'adm_pendidikan_kades', 'adm_alamat_desa', 'adm_kodepos_desa', 'adm_regulasi_desa', 'adm_batas_desa_barat', 'adm_batas_desa_timur', 'adm_batas_desa_utara', 'adm_batas_desa_selatan', 'adm_batas_desa_peta', 'adm_batas_negara_jenis', 'adm_batas_negara_nama', 'adm_jarak_desa_ke_kabupaten', 'adm_jarak_desa_ke_kecamatan', 'adm_foto', 'sarpras_kantor_desa_status', 'sarpras_kantor_desa_kondisi', 'sarpras_kantor_desa_foto', 'sarpras_balai_status', 'sarpras_balai_kondisi', 'sarpras_balai_foto', 'sarpras_aset_meja_baik', 'sarpras_aset_meja_rusak', 'sarpras_aset_kursi_baik', 'sarpras_aset_kursi_rusak', 'sarpras_aset_lemari_baik', 'sarpras_aset_lemari_rusak', 'sarpras_aset_mesin_tik_baik', 'sarpras_aset_mesin_tik_rusak', 'sarpras_aset_komputer_baik', 'sarpras_aset_komputer_rusak', 'sarpras_aset_printer_baik', 'sarpras_aset_printer_rusak', 'sarpras_mobilitas_jumlah_mobil', 'sarpras_mobilitas_jumlah_motor', 'sarpras_mobilitas_jumlah_speedboat', 'sarpras_mobilitas_foto', 'sdm_ASN', 'sdm_non_ASN', 'sdm_jumlah', 'so_sekretaris', 'so_teknis', 'so_kewilayahan', 'so_lainnya', 'plb_status', 'plb_nama', 'pondes_BPD', 'pondes_jumlah_anggota_BPD', 'pondes_pangan', 'pondes_non_pangan', 'pondes_jumlah_RS', 'pondes_jumlah_RSB', 'pondes_jumlah_puskesmas_inap', 'pondes_jumlah_puskesmas', 'pondes_jumlah_posyandu', 'pondes_JAMKESDA', 'pondes_SKTM', 'pondes_PKK', 'pondes_karang_taruna', 'pondes_lembaga_adat', 'pondes_kelompok_tani', 'pondes_kelompok_masyarakat', 'pondes_kantor_pos', 'pondes_industri_kecil', 'pondes_KUD', 'pondes_KOSPIN', 'pondes_koperasi_lainnya', 'pondes_pasar_permanen', 'pondes_pasar_semi', 'pondes_pasar_kaget', 'pondes_bank_pemerintah', 'pondes_bank_swasta', 'pondes_pengadaian', 'authorID', 'image', 'imageCaption', 'file', 'gallery', 'sortNum', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'active'
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
        'ID' => 'int', 'code' => 'string', 'date' => 'datetime', 'name' => 'string', 'groupID' => 'int', 'provinsiID' => 'int', 'kabupatenkotaID' => 'int', 'kecamatanID' => 'int', 'summary' => 'string', 'tags' => 'string', 'content' => 'string', 'adm_luas_wilayah' => 'string', 'adm_jumlah_KK' => 'string', 'adm_jumlah_penduduk' => 'string', 'adm_jumlah_penduduk_pria' => 'string', 'adm_jumlah_penduduk_wanita' => 'string', 'adm_jumlah_penduduk_U0' => 'int', 'adm_jumlah_penduduk_U5' => 'int', 'adm_jumlah_penduduk_U10' => 'int', 'adm_jumlah_penduduk_U15' => 'int', 'adm_jumlah_penduduk_U20' => 'int', 'adm_jumlah_penduduk_U25' => 'int', 'adm_jumlah_penduduk_U30' => 'int', 'adm_jumlah_penduduk_U35' => 'int', 'adm_jumlah_penduduk_U40' => 'int', 'adm_jumlah_penduduk_U45' => 'int', 'adm_jumlah_penduduk_U50' => 'int', 'adm_jumlah_penduduk_U55' => 'int', 'adm_jumlah_penduduk_U60' => 'int', 'adm_jumlah_penduduk_U65' => 'int', 'adm_jumlah_penduduk_U70' => 'int', 'adm_jumlah_penduduk_U75' => 'int', 'adm_ibukota_desa' => 'string', 'adm_gender_kades' => 'string', 'adm_nama_kades' => 'string', 'adm_pendidikan_kades' => 'string', 'adm_alamat_desa' => 'string', 'adm_kodepos_desa' => 'string', 'adm_regulasi_desa' => 'string', 'adm_batas_desa_barat' => 'string', 'adm_batas_desa_timur' => 'string', 'adm_batas_desa_utara' => 'string', 'adm_batas_desa_selatan' => 'string', 'adm_batas_desa_peta' => 'string', 'adm_batas_negara_jenis' => 'string', 'adm_batas_negara_nama' => 'string', 'adm_jarak_desa_ke_kabupaten' => 'string', 'adm_jarak_desa_ke_kecamatan' => 'string', 'adm_foto' => 'string', 'sarpras_kantor_desa_status' => 'string', 'sarpras_kantor_desa_kondisi' => 'string', 'sarpras_kantor_desa_foto' => 'string', 'sarpras_balai_status' => 'string', 'sarpras_balai_kondisi' => 'string', 'sarpras_balai_foto' => 'string', 'sarpras_aset_meja_baik' => 'int', 'sarpras_aset_meja_rusak' => 'int', 'sarpras_aset_kursi_baik' => 'int', 'sarpras_aset_kursi_rusak' => 'int', 'sarpras_aset_lemari_baik' => 'int', 'sarpras_aset_lemari_rusak' => 'int', 'sarpras_aset_mesin_tik_baik' => 'int', 'sarpras_aset_mesin_tik_rusak' => 'int', 'sarpras_aset_komputer_baik' => 'int', 'sarpras_aset_komputer_rusak' => 'int', 'sarpras_aset_printer_baik' => 'int', 'sarpras_aset_printer_rusak' => 'int', 'sarpras_mobilitas_jumlah_mobil' => 'string', 'sarpras_mobilitas_jumlah_motor' => 'string', 'sarpras_mobilitas_jumlah_speedboat' => 'string', 'sarpras_mobilitas_foto' => 'string', 'sdm_ASN' => 'int', 'sdm_non_ASN' => 'int', 'sdm_jumlah' => 'int', 'so_sekretaris' => 'string', 'so_teknis' => 'string', 'so_kewilayahan' => 'string', 'so_lainnya' => 'string', 'plb_status' => 'string', 'plb_nama' => 'string', 'pondes_BPD' => 'string', 'pondes_jumlah_anggota_BPD' => 'int', 'pondes_pangan' => 'string', 'pondes_non_pangan' => 'string', 'pondes_jumlah_RS' => 'int', 'pondes_jumlah_RSB' => 'int', 'pondes_jumlah_puskesmas_inap' => 'int', 'pondes_jumlah_puskesmas' => 'int', 'pondes_jumlah_posyandu' => 'int', 'pondes_JAMKESDA' => 'int', 'pondes_SKTM' => 'int', 'pondes_PKK' => 'int', 'pondes_karang_taruna' => 'int', 'pondes_lembaga_adat' => 'int', 'pondes_kelompok_tani' => 'int', 'pondes_kelompok_masyarakat' => 'int', 'pondes_kantor_pos' => 'string', 'pondes_industri_kecil' => 'int', 'pondes_KUD' => 'int', 'pondes_KOSPIN' => 'int', 'pondes_koperasi_lainnya' => 'int', 'pondes_pasar_permanen' => 'int', 'pondes_pasar_semi' => 'int', 'pondes_pasar_kaget' => 'int', 'pondes_bank_pemerintah' => 'int', 'pondes_bank_swasta' => 'int', 'pondes_pengadaian' => 'int', 'authorID' => 'int', 'image' => 'string', 'imageCaption' => 'string', 'file' => 'string', 'gallery' => 'string', 'sortNum' => 'int', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'active' => 'boolean'
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
