<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Penginapan;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $id = $request->id;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $transaksi = Transaksi::with(['user_pencaris', 'user_pemiliks', 'penginapans'])
            ->where(function ($f) use ($id) {
                if ($id && $id != '' && $id != 'null') {
                    $f->where('id', 'LIKE', '%' . $id . '%');
                }
            })
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);


        if ($request->wantsJson()) {
            return $this->success($transaksi, 'get records data success');
        }

        return view('transaksi', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $limit = $request->limit ?: 10;

        $transaksi = Transaksi::where(function ($query) use ($searchQuery) {
            $query->where('namaPencari', 'like', '%' . $searchQuery . '%')
                ->orWhere('statusTransaksi', 'like', '%' . $searchQuery . '%');
        })
            ->paginate($limit);


        if ($request->wantsJson()) {
            return $this->success($transaksi, 'get records data success');
        }

        return view('transaksi', compact('transaksi', 'searchQuery'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransaksiRequest $request)
    {
        $transaksi = new Transaksi();
        // Handle image upload
        if ($request->hasFile('filename')) {
            $image = $request->file('filename');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $filename);
            $transaksi->buktiBayar = basename($path);
        }
        $transaksi->pencariId = $request->pencariId;
        $transaksi->noTransaksi = $request->noTransaksi;
        $transaksi->tglTransaksi = $request->tglTransaksi;
        $transaksi->tglBooking = $request->tglBooking;
        $transaksi->namaPencari = $request->namaPencari;
        $transaksi->kosId = $request->kosId;
        $transaksi->jlhKamar = $request->jlhKamar;
        $transaksi->pemilikId = $request->pemilikId;
        $transaksi->catatanPesanan = $request->catatanPesanan;
        $transaksi->totalBayar = $request->totalBayar;
        $transaksi->atasNama = $request->atasNama;
        $transaksi->namaBank = $request->namaBank;
        $transaksi->buktiBayar = $request->buktiBayar;
        $transaksi->noRek = $request->noRek;
        $transaksi->statusTransaksi = $request->statusTransaksi;
        $transaksi->save();
        return $this->success($transaksi, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return $this->success($transaksi, 'get record success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransaksiRequest $request, $id)
    {

        $transaksi = Transaksi::findOrFail($id);
        // Handle image upload
        if ($request->hasFile('buktiBayar')) {
            $image = $request->file('buktiBayar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $transaksi->buktiBayar = $filename;
        }
        $transaksi->pencariId = $request->pencariId;
        $transaksi->noTransaksi = $request->noTransaksi;
        $transaksi->tglTransaksi = $request->tglTransaksi;
        $transaksi->tglBooking = $request->tglBooking;
        $transaksi->namaPencari = $request->namaPencari;
        $transaksi->kosId = $request->kosId;
        $transaksi->jlhKamar = $request->jlhKamar;
        $transaksi->pemilikId = $request->pemilikId;
        $transaksi->catatanPesanan = $request->catatanPesanan;
        $transaksi->totalBayar = $request->totalBayar;
        $transaksi->atasNama = $request->atasNama;
        $transaksi->namaBank = $request->namaBank;
        $transaksi->buktiBayar = $request->buktiBayar;
        $transaksi->noRek = $request->noRek;
        $transaksi->statusTransaksi = $request->statusTransaksi;
        $transaksi->save();
        return $this->success($transaksi, 'update data success');
    }

    //pemilik konfirm booking
    public function konfirmBooking($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $penginapanId = $transaksi->kosId;

        $penginapan = Penginapan::findOrFail($penginapanId);
        $penginapan->save();

        $transaksi->statusTransaksi = 'dikonfirmasi pemilik';
        $transaksi->save();

        return $this->success($transaksi, 'berhasil konfirmasi');
    }

    public function sudahCheckin($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $penginapanId = $transaksi->kosId;
        $jumlahKamarDipesan = $transaksi->jlhKamar;

        $penginapan = Penginapan::findOrFail($penginapanId);
        $penginapan->jlhKamar -= $jumlahKamarDipesan;
        $penginapan->save();

        $transaksi->statusTransaksi = 'sukses';
        $transaksi->save();

        return $this->success($transaksi, 'transaksi berhasil');
    }

    public function PemesanBatalBooking($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $penginapanId = $transaksi->kosId;


        $penginapan = Penginapan::findOrFail($penginapanId);

        $penginapan->save();

        $transaksi->statusTransaksi = 'dibatalkan pemesan';
        $transaksi->save();

        return response()->json(['success' => true]);
    }

    public function PemilikBatalBooking($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $penginapanId = $transaksi->kosId;

        $penginapan = Penginapan::findOrFail($penginapanId);

        $penginapan->save();

        $transaksi->statusTransaksi = 'dibatalkan pemilik';
        $transaksi->save();

        return response()->json(['success' => true]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        session()->flash('delete_success', 'Data berhasil dihapus');
        return redirect('/transaksi')->with('success', 'Delete data success');
    }
}
