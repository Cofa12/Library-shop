<?php
namespace App\Contracts;
use App\DTOs\LibraryInput;
use App\Models\Library;
use Illuminate\Database\Eloquent\Collection;
interface LibraryRepositoryInterface
{
    public function create(LibraryInput $input): Library;
    public function update(Library $library, array $data): Library;
    public function delete(Library $library): void;
    public function find(string $id): ?Library;
    public function findAll(): Collection;
}