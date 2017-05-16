<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class MasterPasswordController extends Controller
{
    public function store(Request $request)
    {
        $payload = $request->all();

        $validator = app('validator')->make($payload, [
            'password' => ['required'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create Master Password.', $validator->errors());
        }

        $request->user()->update([
            'master_password' => bcrypt($payload['password']),
            'encryption_key' => bcrypt(str_random(100))
        ]);

        return response([]);
    }

    public function unlock(Request $request)
    {
        $password = $request->password;
        $user = $request->user();

        if (! Hash::check($password, $user->master_password)) {
            throw new Exception('Master Password does not match.');
        }

        return response([
            'encryption_key' => $user->encryption_key
        ]);
    }
}
