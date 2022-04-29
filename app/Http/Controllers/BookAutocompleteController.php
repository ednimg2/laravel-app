<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookAutocompleteController extends Controller
{
    //1. paduodam search value
    //2. einam i db
    //3. gaunam knygas like searhc value
    //4. suformuojam kazkokia structura su pavadinimais
    //5. pagrazinanm structura json formatu
    public function __invoke(Request $request): JsonResponse {
        $searchTerm = $request->get('term');

        if (!$searchTerm || strlen($searchTerm) < 3) {
            return response()->json([]);
        }

        $result = Book::where('title', 'like', $searchTerm . '%')->latest()->take(5)->get();

        $formattedResult = [];

        foreach ($result as $item) {
            $formattedResult[] = ['label' => $item->title, 'value' => $item->id];
        }

        return response()->json($formattedResult);
    }
}
