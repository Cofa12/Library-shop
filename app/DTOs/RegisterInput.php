<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Hash;

class RegisterInput
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
        $this->password = Hash::make($password);
    }
}