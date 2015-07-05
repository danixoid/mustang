<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreLegalRequest;
use App\Models\Legal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LegalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$legals = Legal::all();

        return view('legal/list',['legals' => $legals]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
        $user = User::find($id);

        if (!$user) {

            return redirect()->back()
                ->with('warning','Пользователя не существует!')
                ->withInput();
        }

        return view('legal/create',['id' => $id]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLegalRequest $request
     * @param $id
     * @return Response
     */
	public function store(StoreLegalRequest $request, $id)
	{
        $user = User::find($id);

        if ($user->legal) {

            return redirect()->route('legal.show',$user->legal_id)
                ->with('warning','У вас уже есть фирма.')
                ->withInput();
        }

        $legal = Legal::create(Input::all());

        if(!$legal) {

            return redirect()->route('user.show',$id)
                ->with('warning','Что-то пошло не так')
                ->withInput();
        };

        $user->legal_id = $legal->id;

        $user->save();

        return redirect()->route('legal.edit',$legal->id)
            ->with('success','Успешно создано! Загрузите сканы документов.')
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
		$legal = Legal::find($id);

        if (!$legal) {

            return redirect()->back()
                ->with('warning','Организация не добавлена!')
                ->withInput();
        }

        return view('legal/show',['legal' => $legal]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $legal = Legal::find($id);

        if (!$legal) {

            return redirect()->back()
                ->with('warning','Организация не добавлена!')
                ->withInput();
        }

        return view('legal/edit',['legal' => $legal]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$legal = Legal::find($id);

        if (!$legal) {

            return redirect()->back()
                ->with('warning','Организация не добавлена!')
                ->withInput();
        }

        if (!$legal->update(Input::all())) {

            return redirect()->back()
                ->with('warning','Организация не сохранена!')
                ->withInput();
        }

        return redirect()->route('legal.show',$id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $user = User::where('legal_id',$id)->first();

        if (!$user) {

            return redirect()->route('user.show',$user->id)
                ->with('warning','Пользователь не найден')
                ->withInput();
        }

		if (!Legal::destroy($id)) {

            return redirect()->route('user.show',$user->id)
                ->with('warning','Что-то пошло не так')
                ->withInput();
        }

        return redirect()->route('user.show',$user->id)
            ->with('success','Успешно удалено!')
            ->withInput();
	}

    /**
     * Store the specified resource to storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function filesStore($id) {

        if ($id != Auth::user()->legal_id &&
            Auth::user()->is_admin == 0) {

            return redirect()->back()
                ->with('warning','Запрещено!')
                ->withInput();
        }

        $legal = legal::find($id);

        $files = Input::file('images');

        $counter = 0;

        foreach($files as $file) {

            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file'=> $file), $rules);

            if($validator->passes()){

                $extension = $file->getClientOriginalExtension();
                $filename = $file->getFilename() . '.' . $extension;
                Storage::disk('local')->put($filename, File::get($file));

                $legal->files()->create([
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
    
}
