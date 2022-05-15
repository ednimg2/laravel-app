<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Audit;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function __construct()
    {
//        $this->middleware('role:' . User::ROLE_CONTENT_MANAGER);
    }

    public function index(Request $request): View
    {
        //$blogs = Blog::latest()->where('is_active', 1)->paginate(10);

        /*$blog = DB::update('update blogs set title = "Naujas title 3" where id = :id', [
            'id' => 28
        ]);*/

        /*DB::delete('delete from blogs where id = :id', [
            'id' => 35
        ]);*/

        $blogs = Blog::where('is_active', '=', 1)->get();

//            DB::select('select * from blogs where is_active = :active order by id desc', [
//            'active' => 1,
//        ]);

        $request->session()->reflash();

        return view('blogs.index', compact('blogs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function inactiveList(Request $request): View
    {
        $request->session()->forget('username');
        dump($request->session()->all());
        $blogs = Blog::latest()->where('is_active', 0)->paginate(10);

        return view('blogs.index', compact('blogs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function addToWishlist(Request $request, int $id): RedirectResponse
    {
        $request->session()->push('wishlist', $id);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog added to wishlist successfully');
    }

    public function deleteFromWishlist(Request $request, $id)
    {
        $wishlist = $request->session()->get('wishlist');

        if ($key = array_search($id, $wishlist)) {
            unset($wishlist[$key]);
        }

        $request->session()->put('wishlist', $wishlist);

        return redirect('blogs/wishlist')
            ->with('success', 'Blog deleted from wishlist successfully');
    }

    public function showWishlist(Request $request): View
    {
        $wishlistIDs = $request->session()->get('wishlist');
        $blogs = Blog::wherein('id', $wishlistIDs)->get();

        return view('blogs.wishlist', compact('blogs'));
    }

    public function create(): View
    {
        return view('blogs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        /*$request->validate([
            'title' => 'required|between:5,30',
            'author' => 'required|min:2|max:20',
            'email' => 'bail|required_if:author,mg|email',
            'description' => 'max:200',
            'is_active' => 'accepted_if:author,mg'
        ]);*/

        /*$array = [
            'user' => [
                'name' => 333,
                'email' => 'm.galvanauskas@gmail.com',
                'admin' => true,
            ]
        ];*/

        /*Validator::make($array, [
            'user' => 'array',
            'user.name' => 'string'
        ])->validate();*/

        /*Validator::make($request->all(), [
            'title' => 'numeric|min:5|max:30',
            'author' => 'required|min:2|max:20',
        ],[
            'title.required' => 'This :attribute is required',
            'title.between' => 'Min :min Max :max',
            'author.min' => 'Minimalus ilgis :min',
            'author.max' => 'Maksimalus ilgis :max'
        ])->validate();*/

        /*if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->route('blogs.create')
                ->withErrors($validator)
                ->withInput();
        }*/

        /*if ($validator->fails()) {
            return redirect()->route('blogs.create')
                ->withErrors($validator)
                ->withInput();
        }*/

        $request->validate([
            'title' => 'required|between:2,15',
            'description' => 'required|max:50',
        ]);

        DB::insert('insert into blogs (title, author, description, is_active, slug) values (?, ?, ?, ?, ?)', [
            $request->title,
            $request->author,
            $request->description,
            1,
            'naujas-irasas',
        ]);

        //Blog::create($request->all());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully');
    }

    public function show(Blog $blog): View
    {
        //$blog = Blog::find($id);

        var_dump($blog->audits->count());

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
//        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->is_active = (!empty($request->is_active)) ? 1 : 0;
        $blog->slug = $request->slug;
        $blog->update();

        $changes = [];
        foreach ($blog->getOriginal() as $key => $value) {
            if ($blog->wasChanged([$key]) && $key != 'updated_at') {
                $changes[$key] = $blog->{$key};
            }
        }

        $audit = new Audit();
        $audit->blog()->associate($blog);
        $audit->context = json_encode($changes);
        $audit->save();

//        die();

        $request->session()->flash('warning', 'Flash data message');

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
