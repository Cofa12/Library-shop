<?php

namespace App\Services;

use App\Models\Book;
use App\DTOs\BookInput;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class BookStoreService
{
    public function storeBookAndPdfIfExists(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data = $this->convertCurrencyToCents($request->price,$data);
        $data = $this->storePdf($request->file('pdf_file'),$data);
        $data = $this->storeImage($request->file('cover_image_file'),$data);
        $book = Book::create($data);
        return $book;
    }

    public function updateBook(Request $request, Book $book)
    {
        $data = $request->all();
        if (isset($request->price)) {
            $data = $this->convertCurrencyToCents($request->price, $data);
        }
        
        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file && File::exists(public_path($book->pdf_file))) {
                File::delete(public_path($book->pdf_file));
            }
            $data = $this->storePdf($request->file('pdf_file'), $data);
        }

        if ($request->hasFile('cover_image_file')) {
            if ($book->cover_image && File::exists(public_path($book->cover_image))) {
                File::delete(public_path($book->cover_image));
            }
            $data = $this->storeImage($request->file('cover_image_file'), $data);
        }

        $book->update($data);
        return $book;
    }
    private function storePdf(UploadedFile|null $pdfFile,array $data):array
    {
        if(!$pdfFile)
            return $data;
        $fileName = time() . '_' . $pdfFile->getClientOriginalName();
        $pdfFile->move(public_path('books/pdfs'), $fileName);
        $data['pdf_file'] = 'books/pdfs/' . $fileName;
        return $data;
    }
    private function convertCurrencyToCents(float $price,array $data):array
    {
        if(!$price)
            return $data;
        $data['price'] =  $price * 100;
        return $data;
    }
    private function storeImage(UploadedFile|null $imageFile,array $data):array
    {
        if(!$imageFile)
            return $data;
        $fileName = time() . '_' . $imageFile->getClientOriginalName();
        $imageFile->move(public_path('books/images'), $fileName);
        $data['cover_image'] = 'books/images/' . $fileName;
        return $data;
    }


}