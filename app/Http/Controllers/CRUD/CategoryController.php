<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $data = array(
            'categories' => Category::all()
        );

        return Inertia::render('Petugas/Manages/Category/Index', $data);
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'category' => 'required|string|unique:categories'
        ]);
        $validated['id'] = Str::orderedUuid();

        Category::create($validated);
        return redirect()
            ->route('crud_category.index');
    }
}
