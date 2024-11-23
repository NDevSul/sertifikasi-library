<?php

// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category; // Pastikan ini ada
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); 
        return view('categories.index', compact('categories'));
    }
    

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
    
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
        
            // Menyimpan kategori baru
            Category::create($request->all());
        
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
        
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }   

    public function books(Category $category)
    {
        // Mengambil buku berdasarkan kategori
        $books = $category->books()->get(); // Relasi Many-to-Many dengan buku
    
        return view('categories.books', compact('category', 'books'));
    }
    
        // Display books for a category
        public function showBooks(Category $category)
        {
            $books = $category->books;  // Get books related to this category
            
            // Pass the category and books data to the view
            return view('categories.books', compact('category', 'books'));
        }
    
}