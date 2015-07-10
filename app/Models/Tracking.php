<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model {


    protected $quarded = ['id'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function track_user()
    {
        return $this->hasOne('App\Models\User','id','track_user_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status','id','status_id');
    }

}
