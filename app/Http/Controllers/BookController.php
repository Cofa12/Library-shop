<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Books list',
            'data' => Books::all()
        ], Response::HTTP_OK);
    }

    public function store(Request $request) :JsonResponse
    {
        Books::create($request->all());
        return response()->json([
            'message' => 'Book created successfully',
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $book = Books::find($id);
        if($book){
            return response()->json([
                'message' => 'Book found',
                'data' => $book
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'Book not found',
        ], Response::HTTP_NOT_FOUND);
    }

    public function destroy($id)
    {
        $book = Books::find($id);
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
