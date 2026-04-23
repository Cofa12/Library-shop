<?php

namespace App\Http\Requests;

use App\DTOs\LibraryInput;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LibraryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ];
    }

    public function dto(?User $user): LibraryInput
    {
        return new LibraryInput(
            $this->input('name'),
            $this->input('address'),
            $this->input('phone'),
            $this->input('email'),
            $user?->id
        );
    }
}
