<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Services\BookStoreService;
use App\Services\BookDeletionService;

class BookController extends Controller
{
    public function __construct(
        private BookStoreService $bookStoreService,
        private BookDeletionService $bookDeletionService
    ){}
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    public function store(Request $request) :JsonResponse
    {
        $book = $this->bookStoreService->storeBookAndPdfIfExists($request);
        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResource($book)
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $book = Book::find($id);
        if($book){
            return response()->json([
                'message' => 'Book found',
                'data' => new BookResource($book)
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'Book not found',
        ], Response::HTTP_NOT_FOUND);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if(!$book)   
            return response()->json([
                'message' => 'Book not found',
            ], Response::HTTP_NOT_FOUND);
        
        $this->bookDeletionService->deleteBook($book);
        return response()->json([
            'message' => 'Book deleted successfully',
        ], Response::HTTP_OK);
    }
}
