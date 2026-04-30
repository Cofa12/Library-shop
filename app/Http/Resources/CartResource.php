<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'book' => $this->book ? [
                'id' => $this->book->id,
                'title' => $this->book->name, 
                'price' => $this->book->price,
                'stock' => $this->book->stock,
                'library_id' => $this->book->library_id,
                'cover_image' => $this->book->cover_image,
            ] : null
        ];
    }
}
