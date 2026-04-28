<?php
namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\File;

class BookDeletionService
{
    public function deleteBook(Book $book): void
    {
        if ($book->pdf_path) {
           $this->deletePdf($book->pdf_path);
        }
        $book->delete();
    }

    private function deletePdf(string $pdf_path): void
    {
        $fullPath = public_path($pdf_path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
