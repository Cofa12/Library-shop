<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Books list',
            'data' => BookResource::collection(Book::all())
        ], Response::HTTP_OK);
    }

    public function store(Request $request) :JsonResponse
    {
        $data = $request->all();
        if (isset($data['price'])) {
            $data['price'] =  $data['price'] * 100;
        }

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('books/pdfs'), $fileName);
            $data['pdf_path'] = 'books/pdfs/' . $fileName;
        }

        $book = Book::create($data);
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
        if($book){
            $book->delete();
            return response()->json([
                'message' => 'Book deleted successfully',
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'Book not found',
        ], Response::HTTP_NOT_FOUND);
    }
}
