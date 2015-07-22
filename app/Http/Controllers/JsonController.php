<?php namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\Legal;
use App\Models\Status;
use App\Models\Track;
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

    private $usersRels = array(
            'country',
            'picture',
            'files',
            'country',
            'legal',
            'truck.status',
            'truck.type',
            'truck.country',
            'truck.picture',
            'truck.files',
            'track',
            'phones',
            'cashes');


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
            ->with($this->usersRels)
            ->firstOrFail()
            ->toJson();

        return $user;
	}

    public function inRadius()
    {
        if (!(Input::has('lat') && Input::has('lng') && Input::has('radius'))) {
            return array('error' => 'lat, lng and radius not found');
        }
        $lat = Input::get('lat');
        $lng = Input::get('lng');
        $radius = Input::get('radius');
        $tracks = Track::trackInRadius(array($lat,$lng,$radius))->get();
        //dd($tracks);
        $user = User::with($this->usersRels)
                //->has('phones')
                ->whereIn('truck_id',$tracks->lists('user_id'))
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
    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
