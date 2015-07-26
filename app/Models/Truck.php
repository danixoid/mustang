<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'id', 'truck_id');
    }

    public function files() {
        return $this->morphMany('App\Models\File', 'taggable');
    }

    public function picture() {
        return $this->hasOne('App\Models\File','id','picture_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country','id','country_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status','id','status_id');
    }

    public function truckType()
    {
        return $this->hasOne('App\Models\TruckType','id','truck_type_id');
    }

    public function scopeRequestFields($query,$inputs)
    {
        foreach($inputs as $min => $value)
        {
            if(substr($min,0,4) === 'min_')
            {
                $param = substr($min,4,strlen($min));
                $max = 'max_' . $param;

                if ($inputs[$min] != '')
                {
                    if ($inputs[$max] != '')
                    {
                        $query = $query->whereBetween($param, array($inputs[$min], $inputs[$max]));
                    }
                    else
                    {
                        $query = $query->where($param, '>=', $inputs[$min]);
                    }
                }
                elseif ($inputs[$max] != '')
                {
                    $query = $query->where($param, '<=', $inputs[$max]);
                }
            }
        }

        if (array_key_exists('type_id',$inputs))
        {
            $query = $query->where('truck_type_id',$inputs['type_id']);
        }

        $city = array_key_exists('city',$inputs) ? $inputs['city'] : '';
        $tracker_cnt = array_key_exists('tracker',$inputs) ? 0 : -1;
        $phones_cnt = array_key_exists('phones',$inputs) ? 0 : -1;
        $legal_cnt = array_key_exists('legal',$inputs) ? 0 : -1;

        $query = $query->has('user.tracker','>',$tracker_cnt)
            ->has('user.phones','>',$phones_cnt)
            ->has('user.legal','>',$legal_cnt)
            ->whereHas('user.track', function ($q) use ($city)
            {
                if($city == '') return $q->whereNotNull('city');

                return $q->where('city', $city);
            });

        return $query;
    }
}
