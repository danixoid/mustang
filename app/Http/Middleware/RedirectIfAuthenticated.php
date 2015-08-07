<?php namespace App\Http\Middleware;

use App\Http\Controllers\JsonController;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Facades\Agent;

class RedirectIfAuthenticated {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->check())
		{
            if(Agent::match("Mustang_App")) {
                $request1 = Request::create('json/profile', 'GET');
                return Route::dispatch($request1)->getContent();
            } else {

                return new RedirectResponse(url('/home'));
            }
		}

		return $next($request);
	}

}
