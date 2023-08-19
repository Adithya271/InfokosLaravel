@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Data Transaksi</h1>
    <form action="{{ route('searchtransaksi') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nomor Transaksi</th>
                    <th scope="col">Tanggal Transaksi</th>
                    <th scope="col">Nama Pemesan</th>
                    <th scope="col">Nama Penginapan</th>
                    <th scope="col">Nama Pemilik</th>
                    <th scope="col">Jumlah Kamar Dipesan</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Status Transaksi</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $transaksi)
                <tr>
                     <td>{{ $transaksi->id }}</td>

                    <td>{{ $transaksi->noTransaksi }}</td>
                    <td>{{ $transaksi->tglTransaksi }}</td>
                    <td>{{ $transaksi->namaPencari }}</td>
                    <td>{{ $transaksi->penginapans[0]->namaKos }}</td>
                    <td>{{ $transaksi->user_pemiliks[0]->nama }}</td>
                    <td>{{ $transaksi->jlhKamar }}</td>
                    <td>{{ $transaksi->totalBayar }}</td>
                    <td>{{ $transaksi->statusTransaksi }}</td>
                    <td>

                        <form action="{{ url('/transaksi', ['id' => $transaksi->id]) }}" method="POST">
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
    </div>
</div>

@endsection
