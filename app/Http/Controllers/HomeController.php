<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\TruckTrack;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

    
    public function distancecalc() 
    {
        return view('google/maps/distance');
    }
    
    public function findtruck(Request $request)
    {
        if ($request->isMethod("POST") && $request->ajax()) {
            $lat = Input::get('lat');
            $long = Input::get('long');
            $radius = Input::get('radius');
            $trucks = TruckTrack::with('truck')->trackInRadius(array($lat,$long,$radius))->get()->toJson();
            return $trucks;
        }
        else {
            return view('google/maps/findtruck');
        }
    }
}

