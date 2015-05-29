<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['phone', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    public function picture() {
        return $this->hasOne('App\Models\File');
    }

    public function files()
    {
        return $this->morphMany('App\Models\File', 'taggable');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country');
    }

    public function legal()
    {
        return $this->hasOne('App\Models\Legal');
    }

    public function trucks()
    {
        return $this->hasMany('App\Models\Truck');
    }

    public function tracks()
    {
        return $this->hasManyThrough('App\Models\Track','App\Models\Truck');
    }

    public function phones()
    {
        return $this->hasMany('App\Models\Phone');
    }

    public function cashes()
    {
        return $this->hasMany('App\Models\UserCash');
    }
}
