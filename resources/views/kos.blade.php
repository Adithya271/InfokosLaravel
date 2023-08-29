@extends('layouts.admin')

@section('content')

<div class="container">
   <h1 class="mb-4">Kelola Kos dan Penginapan</h1>
    <form action="{{ route('searchpenginapan') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Cari</button>
        </div>
    </form>
     <div class="pagination">
        {{ $penginapan->links() }}
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                     <th scope="col">ID</th>
                    <th scope="col">Gambar Kos</th>
                    <th scope="col">Nama Kos</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah Kamar</th>
                    <th scope="col">Status Disetujui</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penginapan as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @php
                            $gambarArray = explode(',', $item->gambarKos);
                            $firstImage = trim($gambarArray[0]);
                        @endphp

                        <img src="{{ asset('api/images/' . $firstImage) }}" alt="Gambar Kos" width="50" height="50">
                    </td>
                    <td>{{ $item->namaKos }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->tipe }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->jlhKamar }}</td>
                    <td>
                        @if ($item->disetujui == 0)
                            Ya
                        @else
                            Tidak
                        @endif
                    </td>
                    <td>
                        @if ($item->disetujui == 0)
                            <form action="{{ url('/penginapan/tolak', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            <form action="{{ url('/penginapan/setuju', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <form action="{{ url('/penginapan', ['id' => $item->id]) }}" method="POST">
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
