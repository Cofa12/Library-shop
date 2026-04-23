<?php
namespace App\Contracts;
use App\DTOs\LibraryInput;
use App\Models\Library;
interface LibraryRepositoryInterface
{
    public function create(LibraryInput $input): Library;
    public function update(Library $library, array $data): Library;
    public function delete(Library $library): void;
    public function find(string $id): ?Library;
    public function findAll(): \Illuminate\Database\Eloquent\Collection;
}