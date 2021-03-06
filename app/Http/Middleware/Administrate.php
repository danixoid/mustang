<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class Administrate {

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
        if($this->auth->user()->is_admin < 1) {

            abort(404);
        }

		return $next($request);
	}

}
