<?php

namespace App\Repositories;
use App\Contracts\LibraryRepositoryInterface;
use App\DTOs\LibraryInput;
use App\Models\Library;



class LibraryRepository implements LibraryRepositoryInterface
{

public function create(LibraryInput $input): Library
{
    return Library::create((array) $input);
}

public function update(Library $library, array $data): Library
{
    $library->update($data);
    return $library;
}

public function delete(Library $library): void
{
    $library->delete();
}

public function find(string $id): ?Library
{
    return Library::find($id);
}

public function findAll(): \Illuminate\Database\Eloquent\Collection
{
    return Library::all();
}

}