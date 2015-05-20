<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Legal extends Model {

	//
    public function files()
    {
        return $this->morphMany('File', 'taggable');
    }
}
