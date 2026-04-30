<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Library;
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
        $library = Library::find($request->library_id);
        if (!$library || $library->user_id != auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized. You do not own this library.',
            ], Response::HTTP_FORBIDDEN);
        }

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

    public function update(Request $request, $id) :JsonResponse
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $library = Library::find($book->library_id);
        if ($book->user_id != auth()->id() && (!$library || $library->user_id != auth()->id())) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], Response::HTTP_FORBIDDEN);
        }

        $book = $this->bookStoreService->updateBook($request, $book);
        return response()->json([
            'message' => 'Book updated successfully',
            'data' => new BookResource($book)
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if(!$book)   
            return response()->json([
                'message' => 'Book not found',
            ], Response::HTTP_NOT_FOUND);
        
        $library = Library::find($book->library_id);
        if ($book->user_id != auth()->id() && (!$library || $library->user_id != auth()->id())) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], Response::HTTP_FORBIDDEN);
        }

        $this->bookDeletionService->deleteBook($book);
        return response()->json([
            'message' => 'Book deleted successfully',
        ], Response::HTTP_OK);
    }
}
