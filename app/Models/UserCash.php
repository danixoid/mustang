<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCash extends Model {

	//
    public function billings()
    {
        return $this->morphMany('Billing', 'taggable');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}
