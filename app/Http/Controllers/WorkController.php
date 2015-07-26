<?php namespace App\Http\Controllers;

use App\Http\Requests;


class WorkController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_client', ['only' => 'getMap']);
    }



}
