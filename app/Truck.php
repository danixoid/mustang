<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model {

	//
    public function files()
    {
        return $this->morphMany('File', 'taggable');
    }
}
