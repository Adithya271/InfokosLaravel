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
        $pemilikId = $request->pemilikId;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $transaksi = Transaksi::with('user_pemiliks')
            ->where(function ($f) use ($pemilikId) {
                if ($pemilikId && $pemilikId != '' && $pemilikId != 'null') {
                    $f->where('pemilikId', 'LIKE', '%' . $pemilikId . '%');
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
        $transaksi->pemilikId = $request->pemilikId;
        $transaksi->pemilikId = $request->pemilikId;
        $transaksi->pemilikId = $request->pemilikId;
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
        $transaksi->pemilikId = $request->pemilikId;
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
