@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Manage Pemilik Kos</h1>
    <form action="{{ route('searchpemilik') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Foto Profil</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $pemilik)
                <tr>
                    <td>
                        <img src="{{ asset('storage/images/' . $pemilik->profilGambar) }}" alt="Foto Profil" width="50" height="50">
                    </td>
                    <td>{{ $pemilik->nama }}</td>
                    <td>{{ $pemilik->email }}</td>
                    <td>{{ $pemilik->nomorHp }}</td>
                    <td>
                        <a href="{{ url('/userpemilik/' . $pemilik->id . '/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ url('/userpemilik', ['id' => $pemilik->id]) }}" method="POST">
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
