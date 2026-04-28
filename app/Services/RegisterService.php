<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\DTOs\RegisterInput;
use Illuminate\Support\Facades\Auth;


class RegisterService
{
    public function register(RegisterInput $registerInput):array
    {
        $user = User::create([
            'name' => $registerInput->name,
            'email' => $registerInput->email,
            'password' => $registerInput->password,
        ]);
        $token = Auth::guard('api')->login($user);
        return [$user, $token];
    }
}