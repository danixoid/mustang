<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Phone;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['create', 'store', 'destroy']]);
    }


	/**
	 * Display current resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$id = Auth::user()->id;

        return redirect()->route('user.show',$id);
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

        return redirect()->back();
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

        return redirect()->back();
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getList()
    {
        $users = User::paginate(2);

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
     * @param  int $id
     * @return Response
     * @internal param StoreUserRequest $request
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
     * @param  int $id
     * @return Response
     * @internal param StoreUserRequest $request
     */
	public function update($id)
	{
        if ($id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('user.profile')
                ->with('warning','Не сохранено! Нет доступа.')
                ->withInput();
        }

        $user = User::find($id);

        $data = Input::all();

        $data = array_map(function($val){
            return $val == "" ? null : $val;
        }, $data);

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

        if ($phone->user_id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('message','Запрещено!')
                ->withInput();
        }

        return redirect()->back();
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

        if ($phone->user_id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('message','Запрещено!')
                ->withInput();
        }

        if(!$phone->update(Input::all()))

        return redirect()->back();
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

        if ($phone->user_id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('message','Нет доступа')
                ->withInput();
        }

        $phone->delete();

        return redirect()->back();
    }

    /**
     * Store the specified resource to storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function filesStore($id) {

        if ($id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('user.profile');
        }

        $user = User::find($id);

        $files = Input::file('images');

        $counter = 0;

        foreach($files as $file) {

            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file'=> $file), $rules);

            if($validator->passes()){

                $extension = $file->getClientOriginalExtension();
                $filename = $file->getFilename() . '.' . $extension;
                Storage::disk('local')->put($filename, File::get($file));

                $user->files()->create([
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
            return redirect()->back();
        }
    }


    /**
     * Store the specified resource to storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function fileStore($id) {

        if ($id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->route('user.profile')
                ->with('message','Запрещено!')
                ->withInput();
        }

        $file = Input::file('image');

        $rules = array('file' => 'required|mimes:png,gif,jpeg,jpg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(array('file'=> $file), $rules);

        if($validator->passes()){

            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename() . '.' . $extension;
            Storage::disk('local')->put($filename, File::get($file));

            $user = User::find($id);

            $image_id = $user->files()->create([
                'filename'  => $filename,
                'uri'       => $file->getClientOriginalName(),
                'filetype'  => $file->getClientMimeType()
            ])->id;

            $user->file_id = $image_id;

            $user->save();

        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        return redirect()->back();
    }

}
