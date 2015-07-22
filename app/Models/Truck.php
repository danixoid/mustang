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

    public function scopeRequestFields($query,$inputs)
    {
        if (array_key_exists('type_id',$inputs))
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

            $city = array_key_exists('city',$inputs) ? $inputs['city'] : '';
            $tracker_cnt = array_key_exists('tracker',$inputs) ? 0 : -1;
            $phones_cnt = array_key_exists('phones',$inputs) ? 0 : -1;
            $legal_cnt = array_key_exists('legal',$inputs) ? 0 : -1;

            return $query->has('user.tracker','>',$tracker_cnt)
                ->has('user.phones','>',$phones_cnt)
                ->has('user.legal','>',$legal_cnt)
                ->whereHas('user.track', function ($q) use ($city)
                {
                    if($city == '') return $q->whereNotNull('city');

                    return $q->where('city', $city);
                })
                ->where('truck_type_id',$inputs['type_id'])
                ->whereBetween('width', array($inputs['min_width'], $inputs['max_width']))
                ->whereBetween('length', array($inputs['min_length'], $inputs['max_length']))
                ->whereBetween('height', array($inputs['min_height'], $inputs['max_height']))
                ->whereBetween('capacity', array($inputs['min_capacity'], $inputs['max_capacity']))
                ->whereBetween('volume', array($inputs['min_volume'], $inputs['max_volume']));
        }

        return $query;
    }
}
