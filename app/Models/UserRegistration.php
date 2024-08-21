<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserRegistration extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'usertbl';
    // protected $casts = [
    //     'id' => 'string',
    //   ];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable=['id','full_name','email','password','sex','religion','phone','country_id','state_id','city','street','zip_code','token','status','created-at','updated_at'];
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
        return [
            'id'=>$this->id,
            'full_name'=>$this->full_name,
            'email'=>$this->email,
            'religion'=>$this->religion,
            'sex'=>$this->sex,
            'phone'=>$this->phone,
            'country_id'=>$this->country_id,
            'state_id'=>$this->state_id,
            'city'=>$this->city,
            'street'=>$this->street,
            'zip_code'=>$this->zip_code,
            'status'=>$this->status,

        ];
    }
}
