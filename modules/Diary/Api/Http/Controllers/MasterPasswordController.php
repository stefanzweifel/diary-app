<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Hash;

class MasterPasswordController extends Controller
{
    use Helpers;

    public function store()
    {
        $payload = app('request')->all();

        $validator = app('validator')->make($payload, [
            'password' => ['required'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create Master Password.', $validator->errors());
        }

        app(Auth::class)->user()->update([
            'master_password' => bcrypt($payload['password'])
        ]);

        return $this->response->noContent();
    }

    public function unlock()
    {
        $password = app('request')->get('password');
        $user = app(Auth::class)->user()->first();

        if (! Hash::check($password, $user->master_password)) {
            throw new ResourceException('Master Password does not match.');
        }

        return $this->response->array([
            // Maybe we should encrypt the password hash again?
            'master_password' => $user->master_password
        ]);
    }
}
