<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model {

	//
    public function taggable()
    {
        return $this->morphTo();
    }
}
