<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\TruckTrack;
use Jenssegers\Agent\Facades\Agent;

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
        if(Agent::match("Mustang_App")) {
            $user = User::where("id",Auth::user()->id)
                ->with('picture')
                ->with('country')
                ->with('legal')
                ->with('trucks')
                ->with('tracks')
                ->with('phones')
                ->with('cashes')
                ->firstOrFail()
                ->toJson();
            return $user;
        } else {
            return view('home');
        }
	}

    
    public function distancecalc() 
    {
        return view('google/maps/distance');
    }
    
    public function findtruck(Request $request)
    {
        if (($request->isMethod("POST") && $request->ajax()) || Agent::match("Mustang_App"))
        {
            $lat = Input::get('lat');
            $long = Input::get('long');
            $radius = Input::get('radius');
            $trucks = TruckTrack::with('truck')->trackInRadius(array($lat,$long,$radius))->get()->toJson();
            return $trucks;
        }
        else
        {
            return view('google/maps/findtruck');
        }
    }

}

