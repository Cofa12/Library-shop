<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryRequest;
use App\Models\Library;
use App\Http\Resources\LibraryResource;
use App\Http\Resources\LibrariesResource;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Contracts\LibraryRepositoryInterface;

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
        return LibrariesResource::collection($this->libraryRepository->findAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LibraryRequest $request): JsonResponse
    {
        $this->libraryRepository->create($request->dto(Auth::guard('api')->user()));
        return response()->json([
            'message' => 'Library created successfully',
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
