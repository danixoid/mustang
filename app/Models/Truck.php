<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

	//
    public function files()
    {
        return $this->morphMany('File', 'taggable');
    }
    
    public function tracks()
    {
        return $this->hasMany('TruckTrack');
    }
    
    public function geoPosition()
    {
        return $this->tracks->max("created_at");
    }
    
    // Найти грузовик по GPS и геолокации в базе
    public function scopeTruckInRadius($query,$lat,$long,$radius) 
    {
        $query->whereExists(function($query)
        {
            $query
                ->select(
                    DB::raw("*,
                    `truck_traces`.`long`,
                    ( 6371 * acos( cos( radians(?) ) *
                      cos( radians( `lat` ) )
                      * cos( radians( `long` ) - radians(?)
                      ) + sin( radians(?) ) *
                      sin( radians( `lat` ) ) )
                    ) AS `distance`"))
                ->from('truck_traces')
                ->having("distance", "<", "?")
                ->orderBy("distance")
                ->whereRaw('truck_traces.user_id = trucks.id')
                ->setBindings([$lat, $long, $lat,  $radius]);
        });
    }
}
