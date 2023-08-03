<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Http\Requests\KecamatanRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $namaKecamatan = $request->jenis;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        // Fetch the kecamatan data with the related "penginapan" data using the relationship
        $kecamatan = Kecamatan::with('penginapans')
            ->where(function ($f) use ($namaKecamatan) {
                if ($namaKecamatan && $namaKecamatan != '' && $namaKecamatan != 'null') {
                    $f->where('namaKecamatan', 'LIKE', '%' . $namaKecamatan . '%');
                }
            })
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        $data['paging'] = new PaginationResource($kecamatan);
        $data['records'] = $kecamatan->items();

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
    public function store(KecamatanRequest $request)
    {
        $kecamatan = new Kecamatan();
        $kecamatan->namaKecamatan = $request->namaKecamatan;
        $kecamatan->save();
        return $this->success($kecamatan, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        return $this->success($kecamatan, 'get record success');
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
    public function update(KecamatanRequest $request, $id)
    {

        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->namaKecamatan = $request->namaKecamatan;
        $kecamatan->save();
        return $this->success($kecamatan, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kecamatan::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
