<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryRequest;
use App\Models\Library;
use Illuminate\Http\JsonResponse;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Library::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LibraryRequest $request): JsonResponse
    {
        $library = Library::create($request->validated());

        return response()->json([
            'message' => 'Library created successfully',
            'data' => $library
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library): JsonResponse
    {
        return response()->json($library);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LibraryRequest $request, Library $library): JsonResponse
    {
        $library->update($request->validated());

        return response()->json([
            'message' => 'Library updated successfully',
            'data' => $library
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library): JsonResponse
    {
        $library->delete();

        return response()->json([
            'message' => 'Library deleted successfully'
        ]);
    }
}
