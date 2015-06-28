<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCargoRequest;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CargoController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $cargos = Cargo::all();

        return view('cargo/list', ['cargos' => $cargos]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('cargo/create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCargoRequest $request
     * @return Response
     */
	public function store(StoreCargoRequest $request)
	{
        $data = Input::all();

        $data["user_id"] = Auth::user()->id;

        $cargo = Cargo::create($data);

        if (!$cargo) {
            return redirect()->back()
                ->with('message', 'Почему-то модель не записалась.')
                ->withInput();
        }

        return redirect()->route('cargo.show',array('id' => $cargo->id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $cargo = Cargo::find($id);

        return view('cargo/show', ['cargo' => $cargo]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

        if ($id > 0) {
            $cargo = Cargo::find($id);
        } else {
            $cargo = null;
        }


        return view('cargo/edit', ['cargo' => $cargo]);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCargoRequest $request
     * @param  int $id
     * @return Response
     */
	public function update(StoreCargoRequest $request, $id)
	{
        $cargo = Cargo::find($id);

        if (!$cargo->update(Input::all())) {
            return redirect()->back()
                ->with('message', 'Почему-то модель не записалась.')
                ->withInput();
        }

        return redirect()->route('cargo.show',$cargo->id)
            ->with('message', 'Обновлено.');;
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
