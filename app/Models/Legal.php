<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legal extends Model {

	//
    public function files()
    {
        return $this->morphMany('File', 'taggable');
    }
}
