<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporter extends Model {

	//
    public function user() {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function cargo() {
        return $this->hasOne('App\Models\Cargo','id','cargo_id');
    }

}
