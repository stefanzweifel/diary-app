<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{

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


    public function jwtToken()
    {
        return [
            'token' => JWTAuth::fromUser(auth()->user()),
            'expires_at' => Carbon::now()->addHours(1)->timestamp
        ];
    }

}
