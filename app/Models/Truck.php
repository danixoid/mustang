<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

    //protected $appends = array('track');

    //
    public function files()
    {
        return $this->morphMany('App\Models\File', 'taggable');
    }

    public function picture() {
        return $this->hasOne('App\Models\File','id','file_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country','id','country_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status','id','status_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\TruckType','id','truck_type_id');
    }
    
    public function track()
    {
        return $this->hasOne('App\Models\TruckTrack','id','track_id');
    }

    public function tracks()
    {
        return $this->hasMany('App\Models\TruckTrack');
    }

    /*
        public function getTrackAttribute()
        {
            $track = TruckTrack::where("truck_id",$this->id);
            $createdDate = $track->max("created_at","updated_at");
            return $track->where("created_at",$createdDate)->firstOrFail();
    }*/
}
