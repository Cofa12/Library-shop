<?php

namespace App\Http\Controllers;

use App\Contracts\LibraryRepositoryInterface;
use App\Http\Requests\LibraryRequest;
use App\Models\Library;
use App\Http\Resources\LibraryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends Controller
{
    public function __construct(
        private LibraryRepositoryInterface $libraryRepository
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return LibraryResource::collection($this->libraryRepository->findAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LibraryRequest $request): JsonResponse
    {
        $library = $this->libraryRepository->create($request->dto($request->user()));
        return response()->json([
            'message' => 'Library created successfully',
            'data' => new LibraryResource($library)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library): LibraryResource
    {
        return new LibraryResource($library);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LibraryRequest $request, Library $library): JsonResponse
    {
        $library->update($request->validated());
        
        return response()->json([
            'message' => 'Library updated successfully',
            'data' => new LibraryResource($library)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library): JsonResponse
    {
        $library->delete();

        return response()->json([
            'message' => 'Library deleted successfully'
        ],Response::HTTP_OK);
    }
}
