<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegisterVerificationController extends Controller
{
    public function index()
    {
        $user = User::where('verification_token', request('token'))->first();

        if ($user && $user->verify()) {
            return redirect(route('threads'))
                ->with('flash', 'Your account is now verified! You may now post to the forum.');
        }

        return redirect(route('threads'))->with('flash', 'Unknown token.');
    }
}
