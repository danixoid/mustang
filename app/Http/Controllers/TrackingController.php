<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tracking;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class TrackingController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_client', ['only' => 'index']);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $trackers = Auth::user()->tracker()
            ->orderBy('updated_at','created_at')
            ->get();

		return view('google/maps/tracking',['trackers' => $trackers]);
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
        Input::flash();

		if(!Tracking::create(Input::all()))
        {
            return redirect()->route('truck.list')
                ->with('warning','Не удалось сохранить')
                ->withInput();
        }

        return redirect()->route('tracking')
            ->with('success','Успешно создано!')
            ->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = User::find($id);

        if(!$user)
        {
            return "Не удалось найти грузовик";
        }

        $truck = $user->truck;
        $tracking = $user->tracked()->where('user_id',Auth::user()->id)->first();

        return view('tracking/ajax_form', array(
            'user' => $user,
            'truck' => $truck,
            'tracking' => $tracking
        ));
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

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        Input::flash();

        if(!Tracking::where('tracked_id',$id)->delete())
        {
            return redirect()->back()
                ->with('warning','Не удалось Удалить')
                ->withInput();
        }

        return redirect()->route('rating.create',$id)
            ->with('success','Успешно удалено!')
            ->withInput();
	}

}
