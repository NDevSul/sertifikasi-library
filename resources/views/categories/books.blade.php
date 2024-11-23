@extends('layouts.app')

@section('title', 'Buku Berdasarkan Kategori')

@section('content')
    <h1>Daftar Buku Kategori: {{ $category->name }}</h1>
    
    @if($books->isEmpty())
        <p>Tidak ada buku untuk kategori ini.</p>
    @else
        <ul>
            @foreach ($books as $book)
                <li>{{ $book->title }} - {{ $book->author }}</li>
            @endforeach
        </ul>
    @endif
@endsection
