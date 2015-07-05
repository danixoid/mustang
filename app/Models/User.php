<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

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
	protected $fillable = ['name', 'surname', 'father', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    protected $appends = array('account');

    public function picture() {
        return $this->hasOne('App\Models\File','id','file_id');
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

    public function phones()
    {
        return $this->hasMany('App\Models\Phone');
    }

    public function ratings()
    {
        return $this->hasManyThrough('App\Models\Transporters','App\Models\Rating');
    }

    public function cashes()
    {
        return $this->hasMany('App\Models\UserCash');
    }

    public function transporters() {

        return $this->belongsToMany('App\Models\Transporter');
    }

    public function avgRating()
    {
        $transporters = $this->transporters;
        $average = 0;

        foreach ($transporters as $transporter) {

            $average += $transporter->rating->votes;
        }

        return $average / count($transporters);
    }

    public function getAccount()
    {
        $account = UserAccount::having('end', '>', Carbon::now())->firstOrFail();

        return $account;
    }
}
