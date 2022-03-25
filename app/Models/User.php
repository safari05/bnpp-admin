<?php

namespace App\Models;

use App\Models\Refactored\Users\UsersCamat;
use App\Models\Refactored\Users\UsersDetail;
use App\Models\Refactored\Users\UsersRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public $primaryKey = 'iduser';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iduser' => 'int',
        'username' => 'string',
        'password' => 'string',
        'email' => 'string',
        'created_at' =>
        'datetime',
        'idrole' => 'int',
        'active' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function hasRole($role){
        $role_id = [];
        if($role == 'master'){
            $role_id = [1];
        }else if($role == 'admin'){
            $role_id = [2];
        }else if($role == 'usercontrol'){
            $role_id = [3];
        }else if($role == 'content'){
            $role_id = [4];
        }else if($role == 'camat'){
            $role_id = [5];
        }else if($role == 'semua'){
            $role_id = ['1','2','3','4','5'];
        }

        if(in_array($this->idrole, $role_id)){
            return true;
        }else{
            return false;
        }
    }

    public function role(){
        return $this->hasOne(UsersRole::class, 'idrole', 'idrole');
    }

    public function detail(){
        return $this->hasOne(UsersDetail::class, 'iduser', 'iduser');
    }

    public function kecamatan(){
        return $this->hasOne(UsersCamat::class, 'iduser', 'iduser');
    }
}
