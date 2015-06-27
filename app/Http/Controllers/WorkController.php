<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class WorkController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }


	public function index()
	{
		//
	}


    public function getMap()
    {
        return view('google/maps/in_radius');
    }


    public function getDistance()
    {
        return view('google/maps/distance');
    }

}
