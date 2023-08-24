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
                    <th scope="col">Informasi Rekening Pemilik</th>
                    <th scope="col">Jumlah Kamar Dipesan</th>
                    <th scope="col">Informasi Rekening Pencari</th>
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
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#pemilikModal_{{ $transaksiItem->id }}">
                            View
                        </button>

                        <div class="modal fade" id="pemilikModal_{{ $transaksiItem->id }}" tabindex="-1" role="dialog" aria-labelledby="rekeningModalLabel_{{ $transaksiItem->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rekeningModalLabel_{{ $transaksiItem->id }}">Informasi Rekening Pemilik</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach($transaksiItem->user_pemiliks as $user_pemilik)
                                            <strong>Nama Pemilik :</strong> {{ $user_pemilik->nama }}<br>
                                            <strong>Nama Bank :</strong> {{ $user_pemilik->namaBank }}<br>
                                            <strong>Nomor Rekening Pemilik :</strong> {{ $user_pemilik->noRek }}<br>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $transaksiItem->jlhKamar }}</td>
                    <td>
                     <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#pengirimModal_{{ $transaksiItem->id }}">
                            View
                    </button>
                    <div class="modal fade" id="pengirimModal_{{ $transaksiItem->id }}" tabindex="-1" role="dialog" aria-labelledby="pengirimModalLabel_{{ $transaksiItem->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pengirimModalLabel_{{ $transaksiItem->id }}">Informasi Rekening Pengirim</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                 <div class="modal-body">
                                    <strong>Nama Pengirim :</strong> {{ $transaksiItem->atasNama }}<br>
                                    <strong>Nama Bank :</strong> {{ $transaksiItem->namaBank }}<br>
                                    <strong>Nomor Rekening Pengirim :</strong> {{ $transaksiItem->noRek }}<br>
                                    <strong>Bukti Transfer :</strong><br>
                                    <img src="{{ asset('api/images/' . $transaksiItem->buktiBayar) }}" alt="Gambar Bukti" width="350" height="700"><br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td>
                    <td>{{ $transaksiItem->totalBayar }}</td>
                    <td>{{ $transaksiItem->statusTransaksi }}</td>
                   <td>
                     @if($transaksiItem->statusTransaksi === 'menunggu konfirmasi')
                        <form action="{{ route('transaksiSetuju', ['id' => $transaksiItem->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                Konfirmasi Transaksi
                            </button>
                        </form>
                    @elseif($transaksiItem->statusTransaksi === 'dibatalkan pemesan' || $transaksiItem->statusTransaksi === 'dibatalkan pemilik')
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
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
                @if(session('konfirmasi_success'))
                    <div class="alert alert-success">
                        {{ session('konfirmasi_success') }}
                    </div>
                @endif
                @if(session('batalkan_success'))
                    <div class="alert alert-success">
                        {{ session('batalkan_success') }}
                    </div>
                @endif

        @if(session('delete_success'))
        <div class="alert alert-success">
            {{ session('delete_success') }}
        </div>
        @endif
    </div>
</div>

@endsection
