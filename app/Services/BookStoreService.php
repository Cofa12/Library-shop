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
    private function storePdf(UploadedFile|null $pdfFile,array $data):array
    {
        if(!$pdfFile)
            return $data;
        $fileName = time() . '_' . $pdfFile->getClientOriginalName();
        $pdfFile->move(public_path('books/pdfs'), $fileName);
        $data['pdf_file'] = 'books/pdfs/' . $fileName;
        return $data;
    }
    private function convertCurrencyToCents(int $price,array $data):array
    {
        if(!$price)
            return $data;
        $data['price'] =  $data['price'] / 100;
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