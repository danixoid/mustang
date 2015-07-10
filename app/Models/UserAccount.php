<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model {

    public $timestamps = false;

	//
    public function details()
    {
        return $this->hasOne('App\Models\Account','id','account_id');
    }

    public function billing()
    {
        return $this->morphOne('App\Models\Billing','taggable');
    }
}
