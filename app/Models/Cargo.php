<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model {

	//
    public function status() {
        return $this->morphOne('App\Models\Status','taggable');
    }

    public function transporters () {
        return $this->hasMany('App\Models\Transporter');
    }
}
