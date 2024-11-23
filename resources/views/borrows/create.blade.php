@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6 text-center">Peminjaman Buku</h1>

        @if(session('success'))
            <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Peminjaman Buku Form -->
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('borrows.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="member_id" class="block text-sm font-medium text-gray-700">Pilih Member</label>
                    <select id="member_id" name="member_id" class="form-control w-full p-2 border border-gray-300 rounded mt-2" required>
                        <option value="">-- Pilih Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="book_id" class="block text-sm font-medium text-gray-700">Pilih Buku</label>
                    <select id="book_id" name="book_id" class="form-control w-full p-2 border border-gray-300 rounded mt-2" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                    Pinjam Buku
                </button>
            </form>
        </div>

        <hr class="my-8 border-t-2 border-gray-200">

        <!-- Status Peminjaman Buku -->
        <div class="max-w-3xl mx-auto bg-gray-100 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4 text-center">Status Peminjaman Buku</h2>

            <div>
                @foreach($members as $member)
                    <div class="bg-white p-4 rounded shadow mb-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $member->name }}</h3>
                        <ul class="list-disc pl-5">
                            @forelse($member->books as $book)
                                <li class="flex justify-between items-center mb-2">
                                    <span>{{ $book->title }} - 
                                        <span class="font-bold text-gray-700">
                                            {{ ucfirst($book->pivot->status) }}
                                        </span>
                                    </span>
                                    @if($book->pivot->status == 'borrowed')
                                        <form action="{{ route('borrows.updateStatus', [$book->id, $member->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm py-1 px-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                </li>
                            @empty
                                <li class="text-gray-500">Tidak ada buku yang dipinjam.</li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
