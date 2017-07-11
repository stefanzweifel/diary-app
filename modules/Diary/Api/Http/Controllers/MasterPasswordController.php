<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Diary\Api\Http\Requests\StoreMasterPasswordRequest;
use Diary\Api\Http\Requests\UnlockMasterPasswordRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MasterPasswordController extends Controller
{
    public function store(StoreMasterPasswordRequest $request)
    {
        $request->user()->update([
            'master_password' => bcrypt($request->get('password')),
            'encryption_key' => bcrypt(str_random(100))
        ]);

        return response([], 201);
    }

    public function unlock(UnlockMasterPasswordRequest $request)
    {
        $user = $request->user();

        if (! Hash::check($request->password, $user->master_password)) {
            return response([
                'password' => [
                    'Masterpassword does not match.'
                ]
            ], 422);
        }

        return response([
            'encryption_key' => $user->encryption_key
        ]);
    }
}
