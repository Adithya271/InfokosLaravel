<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Http\Requests\LokasiRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $titik = $request->titik;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $lokasi = Lokasi::where(function ($f) use ($titik) {
            if ($titik && $titik != '' && $titik != 'null') {
                $f->where('titik', 'LIKE', '%' . $titik . '%');
            }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);

        $data['paging'] = new PaginationResource($lokasi);
        $data['records'] = $lokasi->items();

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
    public function store(LokasiRequest $request)
    {
        $lokasi = new Lokasi();
        $lokasi->titik = $request->titik;
        $lokasi->save();
        return $this->success($lokasi, 'save data success');
    }

    public function storeOrUpdate(LokasiRequest $request)
    {
        $existingLokasi = Lokasi::where('titik', $request->titik)->first();

        if ($existingLokasi) {
            // Update the existing location record
            $existingLokasi->update([
                'titik' => $request->titik,
            ]);

            return $this->success($existingLokasi, 'update data success');
        } else {
            // Create a new location record
            $lokasi = new Lokasi();
            $lokasi->titik = $request->titik;
            $lokasi->save();
            return $this->success($lokasi, 'save data success');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return $this->success($lokasi, 'get record success');
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
    public function update(LokasiRequest $request, $id)
    {

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->titik = $request->titik;

        $lokasi->save();
        return $this->success($lokasi, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lokasi::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
