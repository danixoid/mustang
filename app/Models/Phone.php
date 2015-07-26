<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model {

	//

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

}
