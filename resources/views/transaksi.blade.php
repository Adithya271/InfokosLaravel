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
     <div class="pagination">
        {{ $transaksi->links() }}
    </div>

  <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nomor Transaksi</th>
                    <th scope="col">Tanggal Booking</th>
                    <th scope="col">Tanggal Transaksi</th>
                    <th scope="col">Tipe Bayar</th>
                    <th scope="col">Nama Pemesan</th>
                    <th scope="col">Nama Penginapan</th>
                    <th scope="col">Informasi Rekening Pemilik</th>
                    <th scope="col">Jumlah Kamar Dipesan</th>
                    <th scope="col">Informasi Rekening Pencari</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Total Akhir</th>
                    <th scope="col">Status Transaksi</th>
                    <th scope="col">Pesan</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $transaksiItem)
                <tr>
                    <td>{{ $transaksiItem->id }}</td>
                    <td>{{ $transaksiItem->noTransaksi }}</td>
                    <td>{{ $transaksiItem->tglBooking }}</td>
                    <td>{{ $transaksiItem->tglTransaksi }}</td>
                    <td>{{ $transaksiItem->tipeBayar }}</td>
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
                                            <strong>Nomor Handphone Pemilik :</strong> {{ $user_pemilik->nomorHp }}<br>
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
                                    <div style="text-align: center;">
                                        @if($transaksiItem->buktiBayar)
                                            <img src="{{ asset('api/images/' . $transaksiItem->buktiBayar) }}" alt="Gambar Bukti" width="380" height="700"><br>
                                        @else
                                            <p>Tidak ada bukti transfer yang tersedia.</p>
                                        @endif
                                    </div>



                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td>
                    <td>Rp.{{ number_format($transaksiItem->totalBayar, 0, ',', '.') }}</td>
                    <td>Rp.{{ number_format($transaksiItem->totalBayar - 50000, 0, ',', '.') }}</td>
                    <td>{{ $transaksiItem->statusTransaksi }}</td>
                   <td>
                  @if($transaksiItem->statusTransaksi === 'sedang berlangsung')
                    <p>Silahkan Kirimkan Uang Sewa Pemilik</p>
                @endif
                     @if($transaksiItem->statusTransaksi === 'dibatalkan pemilik')
                    <p>Silahkan Kembalikan Uang Transfer Pemesan Jika Sudah Transfer</p>
                @endif
                @if($transaksiItem->statusTransaksi === 'pemilik ajukan hapus')
                    <p>Pemilik Ingin Hapus Data</p>
                @endif
                @if($transaksiItem->statusTransaksi === 'pencari ajukan hapus')
                    <p>Pencari Ingin Hapus Data</p>
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
