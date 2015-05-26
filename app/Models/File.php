<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	//
    public function taggable()
    {
        return $this->morphTo();
    }
}
