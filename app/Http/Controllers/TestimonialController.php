<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
       public function index()
    {
        $testimonials = Testimonial::all();
        return view ('backend.testimonial.index',compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('backend.testimonial.create');
    }

public function store(Request $request)
{
    // Validation
    $request->validate([
        'name' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB max
    ]);

    // Image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image')->store('testimonials', 'public'); // storage/app/public/testimonials
    } else {
        $image = null;
    }

    // Create testimonial
    $testimonial = Testimonial::create([
        'name' => $request->name,
        'designation' => $request->designation,
        'description' => $request->description,
        'image' => $image,
    ]);

    return redirect()->route('testimonials.index')
                     ->with('success', 'Testimonial created successfully!');
}


}
