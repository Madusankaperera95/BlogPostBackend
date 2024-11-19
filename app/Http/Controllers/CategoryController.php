<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke()
    {
        $categories = Category::select('id','category')->get();
        return response()->json(['categories' => $categories],200);
    }
}
