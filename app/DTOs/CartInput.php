<?php

namespace App\DTOs;

class CartInput
{
    public function __construct(
        public string $book_id,
        public int $quantity,
        public string $user_id
    ) {

    }
}