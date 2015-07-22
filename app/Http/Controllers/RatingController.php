<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RatingController extends Controller {

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
	 * @param $id
	 * @return Response
	 */
	public function create($id)
	{
		$tracked = User::find($id);

		return view('rating/create',array('tracked' => $tracked));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StoreRatingRequest $request)
	{
		$data = Input::all();

		if(!Rating::create($data ))
		{
			return redirect()->back()
				->with('warning','Не удалось сохранить отзыв!')
				->withInput();
		}

		return redirect()->route('user.show',$data['tracked_id'])
			->with('success','Отзыв успешно сохранен!')
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
		$rating = Rating::find($id);

		if (!$rating) {

			return redirect()->back()
				->with('warning','Вы не можете оставить отзыв!')
				->withInput();
		}

		return view('rating/show',['rating' => $rating]);
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
