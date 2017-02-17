<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Journal;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class HomeController extends Controller
{
    use Helpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $journals = $this->api->be(auth()->user())->get('journals');
        // return $journals->first()->title;

        return view('home');
    }
}
