<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookDownloadController extends Controller
{
    //1. reikia pasitikrinti ar knyga turi faila
    //2. jei knyga turi faila tai paziureti ar tas failas yra failų sistemoje
    //3. Jeigu yra failas fail7 sistemoje, tuomet suformuoti parsisiuntimo response su tuo filu
    //4. Jei neturim tai tisiog det redirect -> show / mesti not found exception
    public function __invoke(Book $book)
    {
        if (!$book->file) {
            throw new NotFoundHttpException();
        }

        if (Storage::fileExists($book->file)) {
            return Storage::download(Storage::path($book->file));
        }

        throw new NotFoundHttpException();
    }
}
