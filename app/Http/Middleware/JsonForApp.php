<?php namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Facades\Agent;

class JsonForApp {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(!($request->ajax() || Agent::match("Mustang_App"))) {

            return view("errors/404");
        }

        return $next($request);
	}

}
