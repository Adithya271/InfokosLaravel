@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Kelola Iklan</h1>


    <form action="{{ isset($iklan) ? url('/iklan/'.$iklan->id) : url('/iklan') }}" method="POST" enctype="multipart/form-data">
        @csrf


        @if(isset($iklan))
            @method('PUT')
        @endif


        <div class="form-group">
            <label for="gambar">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>


        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

     <div class="pagination">
        {{ $iklan->links() }}
    </div>


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
