<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $ID
 * @property string     $userID
 * @property string     $userdomain
 * @property string     $domaingroup
 * @property string     $password
 * @property DateTime   $date
 * @property string     $no_pendaftaran
 * @property string     $no_anggota
 * @property string     $name
 * @property string     $nickname
 * @property int        $angkatanID
 * @property string     $tempat_lahir
 * @property Date       $tgl_lahir
 * @property string     $jenis_kelamin
 * @property string     $agama
 * @property string     $warga_negara
 * @property string     $no_identitas
 * @property string     $alamat
 * @property string     $telephone
 * @property string     $email
 * @property string     $pekerjaan
 * @property string     $fs_tinggibadan
 * @property string     $fs_beratbadan
 * @property string     $fs_golongandarah
 * @property string     $fs_penyakitpernah
 * @property string     $fs_penyakitsekarang
 * @property string     $fs_cacat
 * @property string     $fs_alergiobat
 * @property string     $fs_alergimakanan
 * @property string     $contactperson1
 * @property string     $contactperson2
 * @property string     $organisasi1
 * @property string     $organisasi2
 * @property string     $organisasi3
 * @property string     $ketrampilan
 * @property string     $image
 * @property DateTime   $entryDate
 * @property string     $entryBy
 * @property string     $entryIP
 * @property DateTime   $approveDate
 * @property string     $approveBy
 * @property string     $approveIP
 * @property DateTime   $updateLast
 * @property string     $updateBy
 * @property string     $updateIP
 * @property int        $levelID
 * @property string     $accessScope
 * @property string     $remark
 * @property string     $random_key
 * @property boolean    $active
 */
class Users extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
        'ID', 'userID', 'userdomain', 'domaingroup', 'password', 'date', 'no_pendaftaran', 'no_anggota', 'name', 'nickname', 'angkatanID', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'agama', 'warga_negara', 'no_identitas', 'alamat', 'telephone', 'email', 'pekerjaan', 'fs_tinggibadan', 'fs_beratbadan', 'fs_golongandarah', 'fs_penyakitpernah', 'fs_penyakitsekarang', 'fs_cacat', 'fs_alergiobat', 'fs_alergimakanan', 'contactperson1', 'contactperson2', 'organisasi1', 'organisasi2', 'organisasi3', 'ketrampilan', 'image', 'entryDate', 'entryBy', 'entryIP', 'approveDate', 'approveBy', 'approveIP', 'updateLast', 'updateBy', 'updateIP', 'levelID', 'accessScope', 'remark', 'random_key', 'active'
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
        'ID' => 'int', 'userID' => 'string', 'userdomain' => 'string', 'domaingroup' => 'string', 'password' => 'string', 'date' => 'datetime', 'no_pendaftaran' => 'string', 'no_anggota' => 'string', 'name' => 'string', 'nickname' => 'string', 'angkatanID' => 'int', 'tempat_lahir' => 'string', 'tgl_lahir' => 'date', 'jenis_kelamin' => 'string', 'agama' => 'string', 'warga_negara' => 'string', 'no_identitas' => 'string', 'alamat' => 'string', 'telephone' => 'string', 'email' => 'string', 'pekerjaan' => 'string', 'fs_tinggibadan' => 'string', 'fs_beratbadan' => 'string', 'fs_golongandarah' => 'string', 'fs_penyakitpernah' => 'string', 'fs_penyakitsekarang' => 'string', 'fs_cacat' => 'string', 'fs_alergiobat' => 'string', 'fs_alergimakanan' => 'string', 'contactperson1' => 'string', 'contactperson2' => 'string', 'organisasi1' => 'string', 'organisasi2' => 'string', 'organisasi3' => 'string', 'ketrampilan' => 'string', 'image' => 'string', 'entryDate' => 'datetime', 'entryBy' => 'string', 'entryIP' => 'string', 'approveDate' => 'datetime', 'approveBy' => 'string', 'approveIP' => 'string', 'updateLast' => 'datetime', 'updateBy' => 'string', 'updateIP' => 'string', 'levelID' => 'int', 'accessScope' => 'string', 'remark' => 'string', 'random_key' => 'string', 'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date', 'tgl_lahir', 'entryDate', 'approveDate', 'updateLast'
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
