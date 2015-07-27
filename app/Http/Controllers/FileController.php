<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\File as Fileentry;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
	public function show($id,$width = 60,$height = 70)
	{
        $entry = Fileentry::find($id);

		if(!$entry)
		{
			$img = Image::make(public_path('img/NO_FACE.png'));
		}
		else
		{
			$img = Image::make(storage_path('app/' . $entry->filename));
		}

		$img->fit($width, $height);

		return $img->response('png');
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
		if(!Fileentry::find($id)->update(Input::all()))
		{
			return redirect()->back()
				->with('warning','Не удалось внести изменения.')
				->withInput();
		}

		return redirect()->back()
		->with('success','Успешно сохранено.')
		->withInput();
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
        Storage::disk('local')->delete($entry->filename);
        $entry->delete();

        return redirect()->back();
	}

}
