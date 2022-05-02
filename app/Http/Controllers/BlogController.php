<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
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

    public function create(): View
    {
        return view('blogs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|between:5,30',
            'author' => 'required|min:2|max:20',
            'email' => 'bail|required_if:author,mg|email',
            'description' => 'max:200',
            'is_active' => 'accepted_if:author,mg'
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

    /*public function edit($slug): View
    {
        $blog = Blog::where('slug', $slug)->first();
        return view('blogs.edit', compact('blog'));
    }*/

    public function update(BlogRequest $request, $id): RedirectResponse
    {
        //$validated = $request->validated();
        //$blog->update($request->all());
        $blog = Blog::find($id);
        //$blog = Blog::where('slug', $slug);

        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->is_active = (!empty($request->is_active)) ?? false;
        $blog->slug = $request->slug;

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
