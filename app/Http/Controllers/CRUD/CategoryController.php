<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validated = Validator::Make($request->except(['_token']), [
            'category' => 'required|unique:categories'
        ]);

        if($validated->fails()) {
            return Inertia::render('Petugas/Manages/Category/Index', [
                'errors' => $validated->errors()
            ]);
        }
        
        Category::create(array_merge($validated->validated(), ['id' => Str::orderedUuid()]));
        return Inertia::render('Petugas/Manages/Category/Index', [
            'categories' => Category::all(),
            'success' => 'Category created successfully.'
        ]);
    }

    public function edit($id) {
        return Inertia::render('Petugas/Manages/Category/Edit', [
            'category' => Category::find($id)
        ]);
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        $validated = $request->validate([
            'category' => 'required|string'
        ]);
        $category->update($validated);
        return redirect()
            ->route('crud_category.index');
    }
}
