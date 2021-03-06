<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckType extends Model {

	//
    public $timestamps = false;

    public function country()
    {
        return $this->hasOne('App\Models\Country');
    }
}
