<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Book;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // Show the form to borrow a book
    public function create()
    {
        $members = Member::all();
        $books = Book::where('status', 'available')->get(); // Only show available books
        return view('borrows.create', compact('members', 'books'));
    }

    // Store the borrow record
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
        ]);

        // Update the book status to borrowed
        $book = Book::find($request->book_id);
        $book->status = 'borrowed';
        $book->save();

        // Attach the book to the member with status borrowed
        $member = Member::find($request->member_id);
        $member->books()->attach($book, ['status' => 'borrowed']);

        return redirect()->route('borrows.create')->with('success', 'Buku berhasil dipinjam!');
    }

    // Update the status of the borrowed book (e.g., mark it as returned)
    public function updateStatus($bookId, $memberId)
    {
        $book = Book::find($bookId);
        $member = Member::find($memberId);

        // Detach the book and mark as returned
        $member->books()->updateExistingPivot($book->id, ['status' => 'returned']);

        // Update the book status to available
        $book->status = 'available';
        $book->save();

        return redirect()->route('borrows.create')->with('success', 'Buku berhasil dikembalikan!');
    }
}

