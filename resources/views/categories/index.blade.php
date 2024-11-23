@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-4">Daftar Kategori Buku</h1>

        <!-- Tombol untuk menambah kategori -->
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-4">Tambah Kategori</a>

        <!-- Tabel Daftar Kategori -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <!-- Tombol Edit dan Hapus Kategori -->
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>                
    </div>
@endsection
