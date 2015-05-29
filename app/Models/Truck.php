<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

	//
    public function files()
    {
        return $this->morphMany('App\Models\File', 'taggable');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
    
    public function tracks()
    {
        return $this->hasMany('App\Models\TruckTrack');
    }


    public function track()
    {
        return $this->tracks->max('created_at');
    }
}
