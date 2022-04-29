<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookExportController extends Controller
{
    public function __invoke()
    {
        $books = Book::all();

        return response()->streamDownload(function () use ($books) {
            $output = fopen('php://output', 'w');
            $header = [
                'id',
                'name',
                'description',
                'created_at'
            ];
            fputcsv($output, $header);

            foreach ($books as $book) {
                fputcsv(
                    $output,
                    [
                        $book->id,
                        $book->title,
                        $book->description,
                        $book->created_at
                    ]);
            }

            fclose($output);
        }, 'books.csv');
    }
}
