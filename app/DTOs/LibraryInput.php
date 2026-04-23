<?php
namespace App\DTOs;
class LibraryInput
{
    public function __construct(
        public $name,
        public $address,
        public $phone,
        public $email,
        public $user_id
    ) {}
}