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
        return User::getCurrent(Auth::user()->id)
            ->firstOrFail()
            ->toJson();
        ;
	}

    public function inRadius()
    {
        if (!(Input::has('lat') && Input::has('lng') && Input::has('radius'))) {
            return array('error' => 'inRadius: lat, lng and radius not found');
        }

        return User::trackInRadius(Input::all())->get()->toJson();
    }

    public function inVisibleRegion()
    {
        if (!(Input::has('lat1') && Input::has('lng1') &&
            Input::has('lat2') && Input::has('lng2')))
        {
            return array('error' => 'inVisibleRegion: bounds not found');
        }

        return User::inBounds(Input::all())
            ->get()
            ->toJson();
    }


    public function autocompleteLegals() {

        $search = Input::get('search');

        $legals = Legal::scopeAutocomplete($search)->get();

        return $legals->toJson();
    }

    public function trucks()
    {
        $pages = Input::has('paginate') ? Input::get('paginate') : 10;

        $trucks = Truck::requestFields(Input::all())->get();

        $users = User::findTrucks($trucks->lists('id'))
            ->paginate($pages);

        return $users->toJson();
    }

    public function trucksQuery()
    {
        if(!Input::has('query')) {
            return array("success" => false, "errors" => ["","Ошибка, не задан параметр QUERY"]);
        }

        $pages = Input::has('paginate') ? Input::get('paginate') : 10;

        $queryString = Input::get("query");

        $users = User::findTrucks($queryString)
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
        return User::getTruck($id)
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

    public function trackingStore()
    {
        Input::flash();

        $tracked_id = Input::get("tracked_id");

        if(!Tracking::create(array(
            "user_id" => Auth::user()->id,
            "tracked_id" => $tracked_id
        )))
        {
            return array("success" => false, "error" => "Not Stored");
        }

        return array("success" => true, "error" => "");
    }

    public function trackingDestroy()
    {
        Input::flash();

        $user_id = Auth::user()->id;
        $tracked_id = Input::get("tracked_id");

        if(!Tracking::getTrackedById($user_id,$tracked_id)->delete())
        {
            return array("success" => false, "error" => "Not destroied");
        }

        return array("success" => true, "error" => "");
    }

}
