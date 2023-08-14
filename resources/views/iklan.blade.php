@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Manage Iklan</h1>

    <!-- Form untuk mengunggah gambar -->
    <form action="{{ isset($iklan) ? url('/iklan/'.$iklan->id) : url('/iklan') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Cek apakah ini untuk mengupdate data -->
        @if(isset($iklan))
            @method('PUT')
        @endif

        <!-- Input untuk gambar -->
        <div class="form-group">
            <label for="gambar">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>

        <!-- Tombol untuk menyimpan data -->
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <!-- Daftar data iklan -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $iklan)
                <tr>
                    <td>{{ $iklan->id }}</td>
                   <td>
                    <img src="{{ asset('api/images/' . $iklan->gambar) }}" alt="Gambar Iklan" width="50" height="50">
                    </td>
                    <td>
                        <form action="{{ url('/iklan', ['id' => $iklan->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
