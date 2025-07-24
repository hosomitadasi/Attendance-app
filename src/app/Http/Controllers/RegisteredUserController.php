<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;

class RegisteredUserController extends Controller
{
    public function store(Request $request, CreateNewUser $creator)
    {
        event(new Registered($user = $creator->create($request->all())));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
