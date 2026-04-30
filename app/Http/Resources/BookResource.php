<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        
        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 100;
        }

        $data['pdf_url'] = isset($data['pdf_file']) ? url($data['pdf_file']) : null;
        $data['cover_image_url'] = isset($data['cover_image']) ? url($data['cover_image']) : null;

        return $data;
    }
}
