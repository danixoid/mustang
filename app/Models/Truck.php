<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

    protected $guarded = ['id'];

    public function user() {
        return $this->hasOne('App\Models\User', 'truck_id', 'id');
    }

    public function files() {
        return $this->morphMany('App\Models\File', 'taggable');
    }

    public function picture() {
        return $this->belongsTo('App\Models\File','picture_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id','id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status','status_id','id');
    }

    public function truckType()
    {
        return $this->belongsTo('App\Models\TruckType','truck_type_id','id');
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
        $tracker_cnt = array_key_exists('tracked',$inputs) ? 0 : -1;
        $phones_cnt = array_key_exists('phones',$inputs) ? 0 : -1;
        $legal_cnt = array_key_exists('legal',$inputs) ? 0 : -1;

        $query = $query->has('user.tracked','>',$tracker_cnt)
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
