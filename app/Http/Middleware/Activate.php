<?php namespace App\Http\Middleware;

use Closure;

class Activate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        if ($this->auth->user()->activated == 0) {

            return new RedirectResponse(url('/home'));
        }

		return $next($request);
	}

}