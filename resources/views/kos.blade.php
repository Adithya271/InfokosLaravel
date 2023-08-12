@extends('layouts.admin')

@section('content')

<div class="container">
   <h1 class="mb-4">Manage Kos dan Penginapan</h1>
    <form action="{{ route('searchpenginapan') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Gambar Kos</th>
                    <th scope="col">Nama Kos</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Status Disetujui</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $penginapan)
                <tr>
                    <td>
                        <img src="{{ asset('api/images/' . $penginapan->gambarKos) }}" alt="Gambar Kos" width="50" height="50">
                    </td>
                    <td>{{ $penginapan->namaKos }}</td>
                    <td>{{ $penginapan->alamat }}</td>
                    <td>{{ $penginapan->tipe }}</td>
                    <td>{{ $penginapan->harga }}</td>
                     <td>
                        @if ($penginapan->disetujui == 0)
                            Ya
                        @else
                            Tidak
                        @endif
                    </td>
                    <td>
                        @if ($penginapan->disetujui == 0)
                            <form action="{{ url('/penginapan/tolak', ['id' => $penginapan->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            <form action="{{ url('/penginapan/setuju', ['id' => $penginapan->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <form action="{{ url('/penginapan', ['id' => $penginapan->id]) }}" method="POST">
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
