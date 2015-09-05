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
use Illuminate\Support\Facades\Session;
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
        $this->middleware('admin', ['only' => ['create', 'store', 'restore', 'destroy']]);
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getList()
    {
        $users = User::paginate(10);

        return view('user/list',array('users' => $users));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getTrash()
    {
        $users = User::onlyTrashed()->paginate(10);

        return view('user/trashed',array('users' => $users));
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
     * Restore the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     * @internal param StoreUserRequest $request
     */
	public function restore($id)
	{
        $user = User::withTrashed()->find($id);

        if(!$user)
        {
            return redirect()->route('user.trash')
                ->with('warning', 'Пользователь не найден!')
                ->withInput();
        }

        $user->deleted_at = null;

        if(!$user->save())
        {
            return redirect()->route('user.trash')
                ->with('warning', 'Невозможно восстановить пользователя!')
                ->withInput();
        }

        return redirect()->route('user.list')
            ->with('success', 'Успешно восстановлен!')
            ->withInput();
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
     * View the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function smsToken($id)
    {
        $phone = Phone::find($id);

        if (!$phone) {
            return redirect()->back()
                ->with('warning','Ошибка! Номер не существует.')
                ->withInput();
        }

        if ($phone->user_id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('message','Запрещено!')
                ->withInput();
        }

        return view("sms/make_token",['phone' => $phone]);
    }

    /**
     * Confirm phone number by sms.
     *
     * @param $id
     * @return Response
     */
    public function confirmSmsToken($id)
    {
        $phone = Phone::find($id);

        if (!$phone) {
            return redirect()->back()
                ->with('warning','Ошибка! Номер не существует.')
                ->withInput();
        }

        if ($phone->user_id != Auth::user()->id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('message','Запрещено!')
                ->withInput();
        }

        if (Session::has('token')) {
            $token = Session::pull('token', '');

            if($token == Input::get('token')) {

                $phone->confirmed = 1;
                $phone->save();

                return redirect()->route('home')
                    ->with('message','Номер телефона +7' . $phone->phone_number . ' успешно активирован!')
                    ->withInput();
            }

        }

        return redirect()->back()
            ->with('warning','Неверно введен токен!')
            ->withInput();
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

            $user->picture_id = $image_id;

            $user->save();

        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        return redirect()->back();
    }

}
