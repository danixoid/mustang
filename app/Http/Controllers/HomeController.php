<?php namespace App\Http\Controllers;

use App\Models\Truck;
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
                ->with(array(
                    'picture',
                    'country',
                    'legal',
                    'truck',
                    'truck.track',
                    'phones',
                    'cashes'))
                ->firstOrFail()
                ->toJson();
            //dd($user->trucks);
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
            /*if (!(Input::has('lat') && Input::has('lng') && Input::has('radius'))) {
                return array("lat lng radius not found");
            }*/
            $lat = '50.41667938232422';//Input::get('lat');
            $lng = '80.26166534423828';//Input::get('lng');
            $radius = 4000;//Input::get('radius');
            $tracks = TruckTrack::trackInRadius(array($lat,$lng,$radius))->get();
            $truckIds = [];

            foreach($tracks as $track) {
                array_push($truckIds, $track->truck_id);
            }

            $user =
                User::with(
                    array(
                        'picture',
                        'country',
                        'legal',
                        'truck.picture',
                        'truck.track',
                        'phones',
                        'cashes'
                    )
                )
                ->whereIn('truck_id',$truckIds)
                ->get()
                ->toJson();
            return $user;
        }
        else
        {
            return view('google/maps/findtruck');
        }
    }

}