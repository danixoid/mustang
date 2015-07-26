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

}
