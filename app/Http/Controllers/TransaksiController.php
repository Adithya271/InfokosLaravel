<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
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

        $data['paging'] = new PaginationResource($transaksi);
        $data['records'] = $transaksi->items();

        return $this->success($data, 'get records data success');
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
        if ($request->hasFile('buktiBayar')) {
            $image = $request->file('buktiBayar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $transaksi->buktiBayar = $filename;
        }
        $transaksi->pencariId = $request->pencariId;
        $transaksi->noTransaksi = $request->noTransaksi;
        $transaksi->tglTransaksi = $request->tglTransaksi;
        $transaksi->namaPencari = $request->namaPencari;
        $transaksi->kosId = $request->kosId;
        $transaksi->pemilikId = $request->pemilikId;
        $transaksi->catatanPesanan = $request->catatanPesanan;
        $transaksi->totalBayar = $request->totalBayar;
        $transaksi->atasNama = $request->atasNama;
        $transaksi->namaBank = $request->namaBank;
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
        $transaksi->namaPencari = $request->namaPencari;
        $transaksi->kosId = $request->kosId;
        $transaksi->pemilikId = $request->pemilikId;
        $transaksi->catatanPesanan = $request->catatanPesanan;
        $transaksi->totalBayar = $request->totalBayar;
        $transaksi->atasNama = $request->atasNama;
        $transaksi->namaBank = $request->namaBank;
        $transaksi->noRek = $request->noRek;
        $transaksi->statusTransaksi = $request->statusTransaksi;
        $transaksi->save();
        return $this->success($transaksi, 'update data success');
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
        return $this->success(null, 'delete data success');
    }
}
