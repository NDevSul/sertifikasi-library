<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    /**
     * @return \Illuminate\Http\Response
     */

     //Function Untuk Membuat Member Baru
    public function create()
    {
        return view('members.create');
    }

    /**
     * Menyimpan member baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
        ]);

        // Simpan member ke database
        Member::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit member.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Memperbarui data member di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
        ]);

        // Perbarui data member
        $member->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil diperbarui!');
    }

    /**
     * Menghapus member dari database.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus!');
    }

    public function books(Member $member)
    {
        // Mengambil buku yang dipinjam oleh anggota
        $books = $member->BorrowedBooks()->get();
    
        return view('members.books', compact('member', 'books'));
    }

}
