<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Legal extends Model {

	//

    use SoftDeletes;

    protected $fillable = ['name', 'director', 'email'];

    public function files()
    {
        return $this->morphMany('App\Models\File', 'taggable');
    }
}
