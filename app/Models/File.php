<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	//
    public function taggable()
    {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
