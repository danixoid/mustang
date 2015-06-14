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
        return $this->hasOne('App\Models\File');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country');
    }

    public function status()
    {
        return $this->hasOne('App\Models\TruckStatus');
    }

    public function type()
    {
        return $this->hasOne('App\Models\TruckType');
    }
    
    public function track()
    {
        return $this->hasOne('App\Models\TruckTrack');
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
