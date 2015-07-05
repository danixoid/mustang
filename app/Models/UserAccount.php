<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model {

	//
    public function details()
    {
        return $this->hasOne('App\Models\Account','id','account_id');
    }
}
