<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . User::ROLE_CONTENT_MANAGER);
    }

    public function index(): View
    {
        $blogs = Blog::latest()->where('is_active', 1)->paginate(10);

        return view('blogs.index', compact('blogs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function inactiveList(): View
    {
        $blogs = Blog::latest()->where('is_active', 0)->paginate(10);

        return view('blogs.index', compact('blogs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(Request $request): View
    {
        return view('blogs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        Blog::create($request->all());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully');
    }

    public function show(Blog $blog): View
    {
        //$blog = Blog::find($id);

        return view('blogs.show', compact('blog'));
    }

    public function edit(Blog $blog): View
    {
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        //$blog->update($request->all());
        $blog = Blog::find($id);

        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->is_active = (!empty($request->is_active)) ?? false;

        $blog->update();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully');
    }
}
