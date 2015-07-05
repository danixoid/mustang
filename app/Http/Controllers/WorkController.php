<?php namespace App\Http\Controllers;

use App\Http\Requests;


class WorkController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
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
