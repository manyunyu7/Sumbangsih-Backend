<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['photo_path', 'role_desc', 'ktp_data'];

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

    function getKTPDataAttribute()
    {
//        $ktp = KTPIdentification::where("user_id", '=', $this->id)->first();
//        if ($ktp != null) {
//            return $ktp;
//        } else {
//            null;
//        }
//
        return "";
    }

    function getRoleDescAttribute()
    {
        $retVal = "";
        switch ($this->role) {
            case 5:
                return "Kecamatan";
                break;
            case 4:
                return "Kelurahan";
                break;
            case 3:
                return "User";
                break;
            case 2 :
                return "Volunteer";
                break;
            case 1 :
                return "Admin";
                break;
        }
    }


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
