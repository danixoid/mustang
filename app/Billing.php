<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model {

	//
    public function taggable()
    {
        return $this->morphTo();
    }
}
