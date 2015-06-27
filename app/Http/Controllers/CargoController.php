<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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

        return view('cargo/edit', ['cargo' => null]);
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
        $cargo = Cargo::where('id', $id)->firstOrFail();

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
        $cargo = Cargo::where('id', $id)->firstOrFail();

        return view('cargo/edit', ['cargo' => $cargo]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $data = Input::all();


        //dd($data);

        if ($id < 1) {
            $cargo = Cargo::create(array(
                'user_id'       =>  Auth::user()->id,
                'capacity'      =>  $data['capacity'],
                'weight'        =>  $data['weight'],
                'budget'        =>  $data['budget'],
                'load'          =>  $data['load'],
                'descriptions'  =>  $data['descriptions'],
                'from'          =>  $data['from'],
                'to'            =>  $data['to'],
            ));
        } else {

            $cargo = Cargo::where('id',$id)->firstOrFail();

            $cargo->user_id     = Auth::user()->id;
            $cargo->capacity    = $data['capacity'];
            $cargo->weight      = $data['weight'];
            $cargo->budget      = $data['budget'];
            $cargo->load        = $data['load'];
            $cargo->descriptions= $data['descriptions'];
            $cargo->from        = $data['from'];
            $cargo->to          = $data['to'];

            $cargo->save();
        }

        return redirect()->route('cargo.show',$cargo->id);
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
