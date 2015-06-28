<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Phone;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['create', 'destroy']]);
    }


	/**
	 * Display current resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$id = Auth::user()->id;

        return redirect()->route('user.show',array('id' => $id));
	}

    /**
	 * Activate user profile.
	 *
	 * @return Response
	 */
	public function activate($id)
	{
		$user = User::find($id);
        $user->activated = 1;
        $user->save();

        return redirect()->route('user.show',array('id' => $id));
	}

    /**
	 * Deactivate user profile.
	 *
	 * @return Response
	 */
	public function deactivate($id)
	{
		$user = User::find($id);
        $user->activated = 0;
        $user->save();

        return redirect()->route('user.show',array('id' => $id));
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getList()
    {
        $users = User::all();

        return view('user/list',array('users' => $users));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('user/create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return Response
     */
	public function store(StoreUserRequest $request)
	{
		$data = Input::all();

        $user = User::create($data);

        if (!$user) {
            return redirect()->back()
                ->with('message', 'Почему-то модель не записалась.')
                ->withInput();
        }

        return redirect()->route('user.profile',array('id' => $user->id));
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

        return view('user/profile', ['user' => $user]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if ($id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('user.profile');
        }

        $user = User::find($id);

        return view('user/edit', ['user' => $user]);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param  int $id
     * @return Response
     */
	public function update(StoreUserRequest $request, $id)
	{
        $data = Input::all();

        $user = User::find($id);

        if (!$user->update($data)) {
            return redirect()->back()
                ->with('message', 'Почему-то модель не записалась.')
                ->withInput();
        }

        return redirect()->route('user.profile',array('id' => $user->id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

        return redirect()->route('user.list');
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param StorePhoneRequest|StoreUserRequest $request
     * @return Response
     */
    public function phoneStore(StorePhoneRequest $request)
    {
        $phone = Phone::create(Input::all());

        return redirect()->route('user.show',array('id' => $phone->user_id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function phoneUpdate($id)
    {
        $phone = Phone::find($id);

        if(!$phone->update(Input::all()))

        return redirect()->route('user/profile',array('id' => $phone->user_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function phoneDestroy($id)
    {
        $phone = Phone::find($id);
        $id = $phone->user_id;
        $phone->delete();

        return redirect()->route('user.show',array('id' => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StoreTruckRequest $request
     * @return Response
     */
    public function truckStore(StoreTruckRequest $request, $id)
    {
        $user = User::find($id);

        $truck = $user->truck;

        if ($truck == null) {

            $user->truck_id = Truck::create(Input::all())->id;
        }
        else {

            $truck->update(Input::all());
        }

        $user->save();

        return redirect()->route('user.show',array('id' => $user->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function truckDestroy($id)
    {
        $user = User::find($id);

        $truck = $user->truck;

        $user->truck_id = null;
        $user->save();

        $truck->delete();


        return redirect()->route('user.show',array('id' => $id));
    }
}
