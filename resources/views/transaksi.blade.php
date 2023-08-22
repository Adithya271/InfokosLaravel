@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Kelola Transaksi</h1>
    <form action="{{ route('searchtransaksi') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Nama">
            <button type="submit" class="btn btn-primary mt-2">Cari</button>
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
                    <th scope="col">Nama Pengirim</th>
                    <th scope="col">Nomor Rekening</th>
                    <th scope="col">Nama Bank</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Status Transaksi</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $transaksiItem)
                <tr>
                    <td>{{ $transaksiItem->id }}</td>
                    <td>{{ $transaksiItem->noTransaksi }}</td>
                    <td>{{ $transaksiItem->tglTransaksi }}</td>
                    <td>{{ $transaksiItem->namaPencari }}</td>
                    <td>
                        @foreach($transaksiItem->penginapans as $penginapan)
                            {{ $penginapan->namaKos }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($transaksiItem->user_pemiliks as $user_pemilik)
                            {{ $user_pemilik->nama }}<br>
                        @endforeach
                    </td>
                    <td>{{ $transaksiItem->jlhKamar }}</td>
                    <td>{{ $transaksiItem->atasNama }}</td>
                    <td>{{ $transaksiItem->noRek }}</td>
                    <td>{{ $transaksiItem->namaBank }}</td>
                    <td>{{ $transaksiItem->totalBayar }}</td>
                    <td>{{ $transaksiItem->statusTransaksi }}</td>
                    <td>
                        @if($transaksiItem->statusTransaksi === 'pending')
                        <form action="{{ route('transaksiSetuju', ['id' => $transaksiItem->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                Setujui Transaksi
                            </button>
                        </form>
                        @elseif($transaksiItem->statusTransaksi === 'mengajukan pembatalan')
                        <form action="{{ route('transaksiBatal', ['id' => $transaksiItem->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                Batalkan Transaksi
                            </button>
                        </form>
                        @endif
                    </td>
                    <td>
                        <form action="{{ url('/transaksi', ['id' => $transaksiItem->id]) }}" method="POST">
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

@endsection
