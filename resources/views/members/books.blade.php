@extends('layouts.app')

@section('title', 'Buku yang Dipinjam')

@section('content')
    <h1>Buku yang Dipinjam oleh: {{ $member->name }}</h1>

    @if($books->isEmpty())
        <p>Anggota ini belum meminjam buku.</p>
    @else
        <ul class="list-group">
            @foreach($books as $book)
                <li class="list-group-item">
                    <strong>{{ $book->title }}</strong> oleh {{ $book->author }}
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Anggota</a>
@endsection
