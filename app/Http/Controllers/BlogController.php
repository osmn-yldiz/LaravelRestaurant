<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Blog List';
        $blogs = Blog::all();
        return view('blog.index', compact('page_title', 'blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'Blog Create';
        $categories = Category::where('type', 1)->get();
        return view('blog.create', compact('page_title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png',
            'description' => 'required',
            'status' => 'required',
        ]);

        $image = $request->file('thumbnail');
        $path = 'uploads/blog/';

        Blog::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'thumbnail' => uploadImage($image, $path),
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'status' => $request->status,
        ]);

        return redirect()->route('blog.index')->with('toast_success', 'Blog Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $page_title = 'Blog Edit';
        $categories = Category::where('type', 1)->get();
        return view('blog.edit', compact('blog', 'categories', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $path = 'uploads/blog/';
            $old_path = public_path($blog->thumbnail);
        }

        $blog->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'thumbnail' => $request->hasFile('thumbnail') ? uploadImage($image, $path, $old_path) : $blog->thumbnail,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'status' => $request->status,
        ]);

        return redirect()->route('blog.index')->with('toast_success', 'Blog Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (file_exists(public_path($blog->thumbnail))) {
            unlink(public_path($blog->thumbnail));
        }
        $blog->delete();
        return back()->with('toast_success', 'Blog Deleted Successfully!');
    }
}
