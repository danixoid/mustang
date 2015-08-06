<?php namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\Legal;
use App\Models\Status;
use App\Models\Track;
use App\Models\Tracking;
use App\Models\Truck;
use App\Models\TruckType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class JsonController extends Controller {

    private $usersRels = array(
            'country',
            'picture',
            'files',
            'legal',/*
            'truck.status',
            'truck.truckType',
            'truck.country',*/
            'truck.picture',
            'truck.files',
            'track',
            'tracker',
            'phones',
            'cashes');


    /**
     * Create a new controller instance.
     *
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mobile');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $id = Auth::user()->id;

        $user = User::where("id", $id)
            ->has("truck")
            ->has("track")
            ->with($this->usersRels)
            ->firstOrFail()
            ->toJson();

        return $user;
	}

    public function inRadius()
    {
        if (!(Input::has('lat') && Input::has('lng') && Input::has('radius'))) {
            return array('error' => 'inRadius: lat, lng and radius not found');
        }
        $lat = Input::get('lat');
        $lng = Input::get('lng');
        $radius = Input::get('radius');
        //$tracks = Track::trackInRadius(array($lat,$lng,$radius))->get();

        $user = User::with($this->usersRels)
            ->has("truck")
            ->has("track")
            ->trackInRadius(array($lat,$lng,$radius))
            //->whereIn('id',$tracks->lists('user_id'))
            ->get()
            ->toJson();

        return $user;
    }

    public function inVisibleRegion()
    {
        if (!(Input::has('lat1') && Input::has('lng1') &&
            Input::has('lat2') && Input::has('lng2')))
        {
            return array('error' => 'inVisibleRegion: bounds not found');
        }

        $lat1 = Input::get('lat1');
        $lng1 = Input::get('lng1');
        $lat2 = Input::get('lat2');
        $lng2 = Input::get('lng2');

        $user = User::with($this->usersRels)
            ->has("truck")
            ->has("track")
            ->trackInVisibleRegion(array('lat1' => $lat1, 'lng1' => $lng1,
                'lat2' => $lat2, 'lng2' => $lng2))
            ->get()
            ->toJson();

        return $user;
    }


    public function autocompleteLegals() {

        $search = Input::get('search');

        $legals = Legal::select('id','name')
            ->where('name', 'like', $search . '%')
            ->orWhere('name', 'like', '%' . $search)
            ->orWhere('name', 'like', '%' . $search . '%')
            ->get();

        return $legals->toJson();
    }

    public function trucks()
    {
        $pages = Input::has('paginate') ? Input::get('paginate') : 10;

        $trucks = Truck::requestFields(Input::all())->get();
        $users = User::with($this->usersRels)
            ->has("truck")
            ->has("track")
            ->whereIn('truck_id',$trucks->lists('id'))
            ->paginate($pages);

        return $users->toJson();
    }

    public function truckTypes()
    {
        return TruckType::all()->toJson();
    }

    public function statuses()
    {
        return Status::all()->toJson();
    }

    public function countries()
    {
        return Country::all()->toJson();
    }

    public function getTruckJson($id)
    {
        return User::where('id',$id)
            ->has("truck")
            ->has("track")
            ->with($this->usersRels)
            ->firstOrFail()
            ->toJson();
    }

    public function trackLatLngStore ($lat,$lng)
    {
        $track = Track::create(array(
            'user_id' => Auth::user()->id,
            'lat' => $lat,
            'lng' => $lng,
        ));

        if(!$track)
        {
            return ['error' => 'cannot save'];
        };

        return ['success' => 'saved'];
    }

}
