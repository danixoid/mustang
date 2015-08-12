<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model {

    protected $guarded = array('id');

    public function tracker()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function tracked()
    {
        return $this->hasOne('App\Models\User','id','tracked_id');
    }

    // SCOPE
    public function scopeTrackedById($query,$user_id,$tracked_id)
    {
        return $query
            ->where("user_id",$user_id)
            ->where('tracked_id',$tracked_id);
    }

}
