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

    protected $appends = ['rating'];
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


    private $usersRels = array(
        'country',
        'picture',
        'files',
        'legal',/*
            'truck.status',
            'truck.truckType',
            'truck.country',*/
        'truck.picture',
        'truck.files',
        'track',
        'tracker',
        'phones',
        'cashes');


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
        return $this->belongsTo('App\Models\Truck','truck_id','id');
    }

    public function track()
    {
        return $this->belongsTo('App\Models\Track','track_id','id');
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




    // CUSTOM SCOPES

    /**
     * @param $query
     * @param $bounds
     * @return mixed
     */
    public function scopeTrackInVisibleRegion ($query,$bounds) {
        return
            $query
                ->whereHas('track', function($q) use ($bounds)
                {
                    return $q
                        ->where('lat','>',$bounds["lat1"])
                        ->where('lat','<',$bounds["lat2"])
                        ->where('lng','>',$bounds["lng1"])
                        ->where('lng','<',$bounds["lng2"]);
                });
    }


    public function scopeTrackInRadius ($query,$binds) {

        return $query
                ->with($this->usersRels)
                ->has("truck")
                ->has("track")
                //->whereIn('id',$tracks->lists('user_id'))
                ->whereHas('track', function($q) use ($binds){
                    $q->whereRaw("(6371 * acos( cos( radians(" . $binds['lat'] . ") ) *
                              cos( radians( `lat` ) )
                              * cos( radians( `lng` ) - radians(" . $binds['lng'] . ")
                              ) + sin( radians(" . $binds['lat'] . " ) ) *
                              sin( radians( `lat` ) ) ) ) < " . $binds['radius']);
                });

    }


    public function scopeInBounds($query,$binds) {

        return $query
            ->with($this->usersRels)
            ->has("truck")
            ->has("track")
            ->trackInVisibleRegion(array('lat1' => $binds['lat1'], 'lng1' => $binds['lng1'],
                'lat2' => $binds['lat2'], 'lng2' => $binds['lng2']));
    }

    public function scopeGetCurrent($query,$id) {

        return $query
            ->where("id", $id)
            ->with("truck")
            ->with("truck.truckType")
            ->with("track")
            ->with($this->usersRels);
    }

    public function scopeFindTrucks($query,$ids) {

        return $query
            ->has("truck")
            ->has("track")
            ->whereIn('truck_id',$ids)
            ->with($this->usersRels);
    }

    public function scopeSearchableTrucks($query,$param) {

        $queryString = "%" . $param . "%";
        return $query
            ->with($this->usersRels)
            ->where("name","like",$queryString)
            ->orWhere("surname","like",$queryString)
            ->orWhere("father","like",$queryString)
            ->orWhereHas("truck",function($q) use ($queryString){
                return $q
                    ->where("brand","like",$queryString)
                    ->orWhere("seria","like",$queryString)
                    ->orWhere("gos_number","like",$queryString);
            });
    }


    public function scopeGetTruck ($query,$id) {
        return $query->where('id',$id)
            ->has("truck")
            ->has("track")
            ->with($this->usersRels);
    }

}
