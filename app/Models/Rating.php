<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model {

	use SoftDeletes;

    public function author() {

        return $this->hasOne('App\Models\User','id','posted_user_id');
    }

}
