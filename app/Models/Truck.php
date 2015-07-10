<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

    protected $appends = array('city');

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'id', 'truck_id');
    }

    public function files() {
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

    public function getCityAttribute()
    {
        $get_API = "http://maps.googleapis.com/maps/api/geocode/json?latlng=";
        $get_API .= round($this->track->lat, 2) . ",";
        $get_API .= round($this->track->lng, 2);

        $jsonfile = file_get_contents($get_API . '&sensor=false');
        $jsonarray = json_decode($jsonfile);

        if (isset($jsonarray->results[1]->address_components[1]->long_name))
        {
            return ($jsonarray->results[1]->address_components[1]->long_name);
        }

        return ('Не известно');
    }


    public function scopeRequestFields($query,$inputs)
    {
        if (count($inputs) > 0)
        {
            foreach($inputs as $key => $value)
            {
                if(substr($key,0,4) === 'min_')
                {
                    if($value == '')
                    {
                        $inputs[$key] = 0;
                    }
                }

                if(substr($key,0,4) === 'max_')
                {
                    if($value == '')
                    {
                        $inputs[$key] = 999999;
                    }
                }
            }
            
            return $query//->where('city', $inputs['city'])
                ->where('truck_type_id',$inputs['type_id'])
                ->whereBetween('width', array($inputs['min_width'], $inputs['max_width']))
                ->whereBetween('length', array($inputs['min_length'], $inputs['max_length']))
                ->whereBetween('height', array($inputs['min_height'], $inputs['max_height']))
                ->whereBetween('capacity', array($inputs['min_capacity'], $inputs['max_capacity']))
                ->whereBetween('volume', array($inputs['min_volume'], $inputs['max_volume']))
                ->whereBetween('volume', array($inputs['min_volume'], $inputs['max_volume']));
        }

        return $query;
    }
}
