<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model {

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(
            function ($track)
            {
                $track->setCity();
            }
        );

        static::created(
            function($track)
            {
                $track->user->track_id = $track->id;
                $track->user->save();
            }
        );

    }

	//
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeTrackInRadius ($query,$binds) {
        return
            $query
                ->selectRaw("*,
                            MAX(`tracks`.`created_at`) created_at,
                            ( 6371 * acos( cos( radians(" . $binds[0] . ") ) *
                              cos( radians( `lat` ) )
                              * cos( radians( `lng` ) - radians(" . $binds[1] . ")
                              ) + sin( radians(" . $binds[0] . " ) ) *
                              sin( radians( `lat` ) ) )
                            ) AS `distance`")
                ->having("distance", "<", $binds[2])
                ->groupBy("user_id")
                ->orderBy("distance");
    }


    public function setCity()
    {
        $get_API = "http://maps.googleapis.com/maps/api/geocode/json?latlng=";
        $get_API .= round($this->lat, 6) . ",";
        $get_API .= round($this->lng, 6);

        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: ru\r\n" .
                    "Cookie: foo=bar\r\n"
            )
        );

        $context = stream_context_create($opts);
        $jsonfile = file_get_contents($get_API . '&sensor=false',false,$context);
        $jsonarray = json_decode($jsonfile);

        $city = 'Не известно';
        $results = $jsonarray->results;

        for($i = 0; $i < count($results); $i++)
        {
            $address_components = $results[$i]->address_components;

            for($j = 0; $j < count($address_components); $j++)
            {
                $types = $address_components[$j]->types;
                $long_name = $address_components[$j]->long_name;

                if(in_array('locality',$types) && in_array('political',$types))
                {
                    $city = $long_name;
                }
            }
        }

        $this->city = $city;

        //return $city;
    }
}
