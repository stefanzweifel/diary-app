<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return [
            'user' => $request->user()->first()
        ];
    }
}
