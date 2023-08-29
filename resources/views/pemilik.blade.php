@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Data Pemilik Kos</h1>
    <form action="{{ route('searchpemilik') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Cari</button>
        </div>
    </form>
     <div class="pagination">
        {{ $userpemilik->links() }}
    </div>
     <div class="mb-3">
       <a href="{{ route('pemilik.create') }}" class="btn btn-success">Tambah Data</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Foto Profil</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userpemilik as $pemilik)
                <tr>
                     <td>{{ $pemilik->id }}</td>
                    <td>
                        <img src="{{ asset('api/images/' . $pemilik->profilGambar) }}" alt="Foto Profil" width="50" height="50">
                    </td>
                    <td>{{ $pemilik->nama }}</td>
                    <td>{{ $pemilik->email }}</td>
                    <td>{{ $pemilik->nomorHp }}</td>
                    <td>
                        <a href="{{ url('/userpemilik/' . $pemilik->id . '/edit') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ url('/userpemilik', ['id' => $pemilik->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                           <button type="submit" onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
         @if(session('tambah_success'))
            <div class="alert alert-success">
                {{ session('tambah_success') }}
            </div>
        @endif
         @if(session('edit_success'))
            <div class="alert alert-success">
                {{ session('edit_success') }}
            </div>
        @endif
         @if(session('delete_success'))
            <div class="alert alert-success">
                {{ session('delete_success') }}
            </div>
        @endif
    </div>
</div>

<style>
.pagination a {
    display: inline-block;
    padding: 0px 10px;
    font-size: 14px;
    background-color: #f1f1f1;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
}

.pagination a:hover {
    background-color: #ddd;
}

.pagination .active {
    background-color: #007bff;
    color: white;
}

.pagination .disabled {
    pointer-events: none;
    background-color: #f1f1f1;
    color: #ccc;
}

.pagination  svg {
    width: 2px;
    height: 2px;

}
</style>



@endsection
