<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Services\PostService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        
    }

    public function index()
    {
        $testimonials = Testimonial::all();
        $postByCategory = $this->postService->groupByPostCategory();
        return view('front.index', compact('testimonials', 'postByCategory'));
    }
}
