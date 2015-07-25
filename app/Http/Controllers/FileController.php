<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\File as Fileentry;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => 'show']);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
        $entry = Fileentry::find($id);

		if(!$entry)
		{
			return redirect('/img/NO_FACE.png');
		}

		$file = Storage::disk('local')->get($entry->filename);

        return response($file, 200)->header('Content-Type', $entry->filetype);
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
        $entry = Fileentry::find($id);

        $user_id = $entry->taggable_id;

        Storage::delete($entry->filename);

        $entry->delete();

        return redirect()->back();
	}

}
