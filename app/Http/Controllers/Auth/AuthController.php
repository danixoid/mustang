<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\User;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Facades\Agent;


class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;


    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @internal param Guard $auth
     * @internal param Registrar $registrar
     */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|string|size:10|unique:phones',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'father' => $data['father'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Phone::create([
            'user_id' => $user->id,
            'phone_number' => $data['phone_number']
        ]);

        //dd($user);
        return $user;
    }

    /*
    public function getLogin() {
        if(Agent::match("Mustang_App")) {
            return array("_token" => csrf_token());
        } else {
            return view("auth.login");
        }
    }*/

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required_without:email|required_if:email,|string|size:10',
            'email' => 'required_without:phone_number|required_if:phone_number,|email',
            'password' => 'required',
        ]);

        $phone_number = Input::get('phone_number');
        $password = Input::get('password');
        $email = Input::get('email')
            ?: User::whereHas('phones',
                function($q) use ($phone_number) {
                    $q->where('phone_number', $phone_number);
                }
            )->first()['email'];

        $credentials = ['email' => $email, 'password' => $password];

        //$request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember')))
        {
            return redirect()->action("WelcomeController@index");
        }

        if (Agent::match("Mustang_App")) {

            return ["error" => "email, phone_number or password is incorrect"];
        } else {

            return redirect($this->loginPath())
                ->withInput($request->only('email', 'phone_number', 'remember'))
                ->withErrors([
                    'email' => $this->getFailedLoginMessage(),
                ]);
        }
    }

}
