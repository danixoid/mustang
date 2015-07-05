<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreTruckRequest;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TruckController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $trucks = Truck::paginate(2);

        return view('truck/list',['trucks' => $trucks]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return Response
     */
	public function create($id)
	{

		return view('truck/create',['id' => $id]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTruckRequest $request
     * @return Response
     * @internal param $id
     */
	public function store(StoreTruckRequest $request, $id)
    {

        if ($id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('truck.show');
        }

        $user = User::find($id);

        $user->truck_id = Truck::create(Input::all())->id;

        $user->save();

        return redirect()->route('truck.edit',$user->truck_id);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$truck = Truck::find($id);

        if(!$truck) {
            return redirect()->back()
                ->with('warning','Грузовик не существует!')
                ->withInput();
        }

        return view('truck/show',['truck' => $truck]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $truck = Truck::find($id);

        if($truck == null) {
            return redirect()->back()
                ->with('warning','Создайте грузовик')
                ->withInput();
        }

        return view('truck/edit',['truck' => $truck]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if ($id != Auth::user()->truck_id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('truck.show',$id)
                ->with('warning','Создайте грузовик')
                ->withInput();;
        }

        $user = User::where('truck_id',$id)->first();
        $user->truck->update(Input::all());

        return redirect()->route('truck.show',$id)
            ->with('success','Успешно сохранено!')
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
        if ($id != Auth::user()->truck_id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('truck.show',$id);
        }

        $user = User::where('truck_id',$id)->first();

        Truck::find($id)->delete();

        return redirect()->route('user.show',$user->id)
            ->with('success','Успешно удалено!')
            ->withInput();;
	}


    /**
     * Store the specified resource to storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function filesStore($id) {

        if ($id != Auth::user()->truck_id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('warning','Запрещено!')
                ->withInput();
        }

        $truck = Truck::find($id);

        $files = Input::file('images');

        $counter = 0;

        foreach($files as $file) {

            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file'=> $file), $rules);

            if($validator->passes()){

                $extension = $file->getClientOriginalExtension();
                $filename = $file->getFilename() . '.' . $extension;
                Storage::disk('local')->put($filename, File::get($file));

                $truck->files()->create([
                    'filename'  => $filename,
                    'uri'       => $file->getClientOriginalName(),
                    'filetype'  => $file->getClientMimeType()
                ]);

            } else {
                $counter++;
            }
        }

        if($counter > 0) {

            return redirect()->back()
                ->withInput()
                ->withErrors($validator);

        } else {
            return redirect()->back()
                ->with('success','Успешно загружено!')
                ->withInput();;
        }
    }


    /**
     * Store the specified resource to storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function fileStore($id) {

        if ($id != Auth::user()->truck_id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('warning','Запрещено!')
                ->withInput();
        }

        $file = Input::file('image');

        $rules = array('file' => 'required|mimes:png,gif,jpeg,jpg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(array('file'=> $file), $rules);

        if($validator->passes()){

            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename() . '.' . $extension;
            Storage::disk('local')->put($filename, File::get($file));

            $truck = Truck::find($id);

            $image_id = $truck->files()->create([
                'filename'  => $filename,
                'uri'       => $file->getClientOriginalName(),
                'filetype'  => $file->getClientMimeType()
            ])->id;

            $truck->file_id = $image_id;

            $truck->save();

        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        return redirect()->back()
            ->with('success','Успешно загружено!')
            ->withInput();;
    }
}
