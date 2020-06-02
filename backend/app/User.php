<?php

namespace App;

use Adldap\Laravel\Facades\Adldap;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  
    use HasApiTokens, Notifiable;

   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return true;
        $user = Adldap::search()->findBy('sAMAccountname', $this->username);
        if ($user) {
            $res['username'] = $user->samaccountname[0];
            $res['fullname'] = $user->cn[0];
            $res['employer_id'] = $user->employeenumber[0];
            $res['mail'] = $user->mail[0];
            $res['foto'] = base64_encode($user->thumbnailphoto[0]);
            $distinguishedname = $user->distinguishedname[0];
            $distinguishedname = substr($distinguishedname, strpos($distinguishedname, 'DC'), 1000);
            $res['account_suffix'] = str_replace(',', '.', str_ireplace('dc=', '', $distinguishedname));
        } else {
            return false;
        }
        return Adldap::auth()->attempt($this->username . '@' . $res['account_suffix'], $password, $bindAsUser = true);
        // $search = Adldap::search()->get();
        // dd($search);
        // dd(Adldap::auth()->attempt('qg9592@and', '@Start123', $bindAsUser = true));
        // Yii::$app->ad->auth()->attempt(
        // $this->username.'@'.$ADuser['account_suffix'], $this->password)
        // return Hash::check($password, $this->password);
    }
}
