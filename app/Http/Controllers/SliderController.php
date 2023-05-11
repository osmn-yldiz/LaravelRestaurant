<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Slider List';
        $sliders = Slider::all();
        return view("slider.index", compact("page_title", "sliders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'Slider Create';
        return view("slider.create", compact("page_title"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png',
        ]);

        $image = $request->file('thumbnail');
        $path = 'uploads/slider/';

        Slider::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'thumbnail' => uploadImage($image, $path),
        ]);

        return redirect()->route('slider.index')->with('toast_success', 'Slider Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $page_title = 'Slider Edit';
        return view("slider.edit", compact("page_title", "slider"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $path = 'uploads/slider/';
            $old_path = public_path($slider->thumbnail);
        }

        $slider->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'thumbnail' => $request->hasFile('thumbnail') ? uploadImage($image, $path, $old_path) : $slider->thumbnail,
        ]);

        return redirect()->route('slider.index')->with('toast_success', 'Slider Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if (file_exists(public_path($slider->thumbnail))) {
            unlink(public_path($slider->thumbnail));
        }

        $slider->delete();
        return back()->with('toast_success', 'Slider Deleted Successfully!');
    }
}
