@extends('layouts.admin')

@section('content')

<div class="container">
   <h1 class="mb-4">Manage Pencari Kos</h1>
    <form action="{{ route('searchpencari') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </div>
    </form>
    <div class="mb-3">
       <a href="{{ route('pencari.create') }}" class="btn btn-success">Tambah Data</a>
    </div>
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
                @foreach($records as $pencari)
                <tr>
                    <td>
                        <img src="{{ asset('api/images/' . $pencari->profilGambar) }}" alt="Foto Profil" width="50" height="50">
                    </td>
                    <td>{{ $pencari->nama }}</td>
                    <td>{{ $pencari->email }}</td>
                    <td>{{ $pencari->nomorHp }}</td>
                    <td>
                        <a href="{{ url('/userpencari/' . $pencari->id . '/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                         &nbsp; <!-- Non-breaking space for spacing -->
                        <form action="{{ url('/userpencari', ['id' => $pencari->id]) }}" method="POST">
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
