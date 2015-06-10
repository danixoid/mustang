<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckTrack extends Model {

	//
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck')->with('user');
    }

    public function scopeTrackInRadius ($query,$binds) {
        return
            $query
                ->selectRaw("*,
                            MAX(`truck_tracks`.`created_at`) created_at,
                            ( 6371 * acos( cos( radians(" . $binds[0] . ") ) *
                              cos( radians( `lat` ) )
                              * cos( radians( `lng` ) - radians(" . $binds[1] . ")
                              ) + sin( radians(" . $binds[0] . " ) ) *
                              sin( radians( `lat` ) ) )
                            ) AS `distance`")
                //->leftJoin('trucks','trucks.id','=','truck_tracks.truck_id')
                ->having("distance", "<", $binds[2])
                ->groupBy("truck_id")
                ->orderBy("distance");
    }
}
