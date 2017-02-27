<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Dingo\Api\Auth\Auth;

class UserController extends Controller
{
    public function index()
    {
        return app(Auth::class)->user()->first();
    }
}
