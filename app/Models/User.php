<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserAccount;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

    protected $append = ['rating'];
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
	//protected $fillable = ['name', 'surname', 'father', 'email', 'password'];
	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function picture() {
        return $this->hasOne('App\Models\File','id','picture_id');
    }

    public function files()
    {
        return $this->morphMany('App\Models\File', 'taggable');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country','id','country_id');
    }

    public function legal()
    {
        return $this->hasOne('App\Models\Legal','id','legal_id');
    }

    public function truck()
    {
        return $this->hasOne('App\Models\Truck','id','truck_id');
    }

    public function track()
    {
        return $this->hasOne('App\Models\Track','id','track_id');
    }

    public function tracks()
    {
        return $this->hasMany('App\Models\Track');
    }

    public function phones()
    {
        return $this->hasMany('App\Models\Phone');
    }

    public function cashes()
    {
        return $this->hasMany('App\Models\UserCash');
    }

    public function tracker()
    {
        return $this->hasMany('App\Models\Tracking','user_id','id');
    }

    public function tracked()
    {
        return $this->hasMany('App\Models\Tracking','tracked_id','id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating','tracked_id','id');
    }

    public function getRatingAttribute()
    {
        return $this->ratings()->avg('votes');
    }

}
