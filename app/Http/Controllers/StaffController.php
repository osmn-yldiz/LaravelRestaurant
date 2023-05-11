<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Staff List';
        $staffs = Staff::all();
        return view('staff.index', compact('staffs', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'Staff Create';
        return view('staff.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png',
        ]);

        $image = $request->file('thumbnail');
        $path = 'uploads/staff/';

        Staff::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'thumbnail' => uploadImage($image, $path),
        ]);

        return redirect()->route('staff.index')->with('toast_success', 'Staff Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $page_title = 'Staff Edit';
        return view('staff.edit', compact('staff', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $path = 'uploads/staff/';
            $old_path = public_path($staff->thumbnail);
        }

        $staff->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'thumbnail' => $request->hasFile('thumbnail') ? uploadImage($image, $path, $old_path) : $staff->thumbnail,
        ]);

        return redirect()->route('staff.index')->with('toast_success', 'Staff Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        if (file_exists(public_path($staff->thumbnail))) {
            unlink(public_path($staff->thumbnail));
        }
        $staff->delete();
        
        return back()->with('toast_success', 'Staff Deleted Successfully!');
    }
}
