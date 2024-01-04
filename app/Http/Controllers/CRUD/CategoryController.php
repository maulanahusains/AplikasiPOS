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
            'category' => 'required|string'
        ]);
        $validated['id'] = Str::orderedUuid();

        $result = Category::where('category', $validated['category'])->first();
        
        if($result !== null) {
            return Inertia::render('Petugas/Manages/Category/Index', [
                'categories' => Category::all(),
                'error' => 'Category already exists.'
            ]);
        }
        
        Category::create($validated);
        return Inertia::render('Petugas/Manages/Category/Index', [
            'categories' => Category::all(),
            'success' => 'Category created successfully.'
        ]);
    }

    public function edit(Category $category) {
        return Inertia::render('Petugas/Manages/Category/Edit', $category);
    }

    public function update(Request $request, Category $category) {
        $validated = $request->validate([
            'category' => 'required|string'
        ]);
        $category->update($validated);
        return redirect()
            ->route('crud_category.index');
    }
}
