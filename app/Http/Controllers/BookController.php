<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        {
            // Get all categories for the filter dropdown
            $categories = Category::all();
    
            // Check if a category is selected for filtering
            if ($request->has('category_id') && $request->category_id != '') {
                // Get books filtered by the selected category ID
                $books = Book::whereHas('categories', function($query) use ($request) {
                    $query->where('categories.id', $request->category_id);
                })->get();
            } else {
                // No filter selected, show all books
                $books = Book::all();
            }
    
            // Return the view with the filtered books and categories
            return view('books.index', compact('books', 'categories'));
        }

        $books = Book::with('categories')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'categories' => 'required|array', // pastikan ada kategori yang dipilih
            'categories.*' => 'exists:categories,id', // pastikan kategori ada di database
        ]);

        $book = Book::create($request->only('title', 'author'));
        $book->categories()->sync($request->categories); // Menyimpan relasi buku dengan kategori

        return redirect()->route('books.index');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $book->update($request->only('title', 'author'));
        $book->categories()->sync($request->categories); // Menyimpan relasi yang diperbarui

        return redirect()->route('books.index');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index');
    }
}
