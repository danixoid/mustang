<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model {

	use SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function author()
    {
        return $this->hasOne('App\Models\User','id','tracked_id');
    }

}
