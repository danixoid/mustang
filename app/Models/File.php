<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model {

    use SoftDeletes;

	protected $guarded = ['id'];

    public function taggable()
    {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function truck() {
        return $this->belongsTo('App\Models\Truck');
    }
}
