<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model {

	//
    protected $fillable = ['user_id','capacity','weight','budget','load','descriptions','from','to'];

    public function user () {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function transporters () {
        return $this->hasMany('App\Models\Transporter');
    }
}
