<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Http\Requests\RekeningRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class RekeningController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $pemilikId = $request->pemilikId;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $rekening = Rekening::with('user_pemiliks')
            ->where(function ($f) use ($pemilikId) {
                if ($pemilikId && $pemilikId != '' && $pemilikId != 'null') {
                    $f->where('pemilikId', 'LIKE', '%' . $pemilikId . '%');
                }
            })
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        $data['paging'] = new PaginationResource($rekening);
        $data['records'] = $rekening->items();

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
    public function store(RekeningRequest $request)
    {
        $rekening = new Rekening();
        $rekening->pemilikId = $request->pemilikId;
        $rekening->namaBank = $request->namaBank;
        $rekening->noRek = $request->noRek;
        $rekening->atasNama = $request->atasNama;
        $rekening->save();
        return $this->success($rekening, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rekening = Rekening::findOrFail($id);
        return $this->success($rekening, 'get record success');
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
    public function update(RekeningRequest $request, $id)
    {

        $rekening = Rekening::findOrFail($id);
        $rekening->pemilikId = $request->pemilikId;
        $rekening->namaBank = $request->namaBank;
        $rekening->noRek = $request->noRek;
        $rekening->atasNama = $request->atasNama;
        $rekening->save();
        return $this->success($rekening, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rekening::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
