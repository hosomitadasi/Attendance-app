<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;

class RegisteredUserController extends Controller
{
    public function store(
        Request $request,
        CreateNewUser $creator
    ) {
        $user = $creator->create($request->all());

        Auth::login($user);

        return redirect()->route('attendance.create');
    }
}
