<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $title = $request->get('search');

        $books = Book::where(
            'title',
            'like',
            '%' . $title . '%'
        )->latest()->paginate(5);

        return view('books.index', compact('books'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')
            ->with('success','Book created successfully.');
    }

    public function show(Book $book): View
    {
        return view('books.show');
    }

    public function edit(Book $book): View
    {
        return view('books.edit',compact('book'));
    }

    // 1. Pasitikrinam ar gavom faila
    // 2. jeigu gavom faila ji išsaugome failų sistemoje
    // 3. failo pavadinima, kurį išsaugojom failų sistemoje naudom saugojant duomenų bazėj
    // 4. jeigu failas nėra gaunamas, tai file propertis neturėtų būti perrašomas į null.

    public function update(Request $request, Book $book): RedirectResponse
    {
        $file = $request->file('file');

        if ($file && $file->isValid()) {
            //uzsiuploadinti;
            $path = $file->store('files');
            $book->file = $path;
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')
            ->with('success','Book updated successfully');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success','Book deleted successfully');
    }
}
