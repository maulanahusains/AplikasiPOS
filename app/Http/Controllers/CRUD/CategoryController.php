<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $data = array(
            'categories' => Category::all()
        );

        return Inertia::render('Petugas/Manages/Category/Index', $data);
    }
}
