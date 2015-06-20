<?php namespace App\Http\Controllers;


use App\Models\TruckTrack;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class JsonController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
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
            ->with(array(
                'country',
                'picture',
                'files',
                'country',
                'legal',
                'truck.country',
                'truck.picture',
                'truck.files',
                'truck.track',
                'phones',
                'cashes'))
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
        $tracks = TruckTrack::trackInRadius(array($lat,$lng,$radius))->get();
        $truckIds = [];

        foreach($tracks as $track) {
            array_push($truckIds, $track->truck_id);
        }

        $user = User::with([
                    'country',
                    'picture',
                    'files',
                    'country',
                    'legal',
                    'truck.country',
                    'truck.picture',
                    'truck.files',
                    'truck.track',
                    'phones',
                    'cashes'
                ])
                ->whereIn('truck_id',$truckIds)
                ->get()
                ->toJson();

        return $user;
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
