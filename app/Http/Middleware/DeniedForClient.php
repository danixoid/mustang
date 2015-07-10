<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class DeniedForClient {

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
     * @param  \Illuminate\Http\Request $request
     * @param callable $next
     * @return mixed
     * @internal param callable $nextin
     */
    public function handle($request, Closure $next)
    {
        if(count($this->auth->user()->phones) == 0  ||
            !$this->auth->user()->country           ||
            !$this->auth->user()->truck
        )
        {
            return redirect()->route('home')
                ->with('warning','Вход только для грузоотправителей')
                ->withInput();;
        }

        return $next($request);
    }
}
