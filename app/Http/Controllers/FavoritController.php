<?php

namespace App\Http\Controllers;


use App\Models\Favorit;
use App\Http\Requests\FavoritRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Support\Facades\Validator;

class FavoritController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $namaKos = $request->namaKos;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';
        $emailPenambah = $request->emailPenambah; 

        $favorit = Favorit::where(function ($f) use ($namaKos, $emailPenambah) {
            if ($namaKos && $namaKos != '' && $namaKos != 'null') {
                $f->where('namaKos', 'LIKE', '%' . $namaKos . '%');
            }

            if ($emailPenambah && $emailPenambah != '' && $emailPenambah != 'null') {
                $f->where('emailPenambah', $emailPenambah);
            }
        })
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        $data['paging'] = new PaginationResource($favorit);
        $data['records'] = $favorit->items();

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
    public function store(FavoritRequest $request)
    {
        $favorit = new Favorit();

        // Handle image upload
        if ($request->hasFile('gambarKos')) {
            $image = $request->file('gambarKos');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $favorit->gambarKos = str_replace('"', '', $filename);
        }
        $favorit->namaKos = $request->namaKos;
        $favorit->alamat = $request->alamat;
        $favorit->cerita = $request->cerita;
        $favorit->fasKamar = $request->fasKamar;
        $favorit->fasKamarmandi = $request->fasKamarmandi;
        $favorit->disetujui = $request->disetujui;
        $favorit->fasParkir = $request->fasParkir;
        $favorit->fasUmum = $request->fasUmum;
        $favorit->harga = $request->harga;
        $favorit->hargaPromo = $request->hargaPromo;
        $favorit->isPromo = $request->isPromo;
        $favorit->pemilikId = $request->pemilikId;
        $favorit->jenis = $request->jenis;
        $favorit->lokasi = $request->lokasi;
        $favorit->jlhKamar = $request->jlhKamar;
        $favorit->namaKecamatan = $request->namaKecamatan;
        $favorit->peraturan = $request->peraturan;
        $favorit->spektipekamar = $request->spektipekamar;
        $favorit->tipe = $request->tipe;
        $favorit->gambarKos = $request->gambarKos;
        $favorit->emailPenambah = $request->emailPenambah;
        $favorit->save();
        return $this->success($favorit, 'save data success');
    }

    public function update(FavoritRequest $request, $id)
    {
        $favorit = Favorit::findOrFail($id);

        // Handle image update
        if ($request->hasFile('gambarKos')) {
            $image = $request->file('gambarKos');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $favorit->gambarKos = str_replace('"', '', $filename);
        }
        $favorit->namaKos = $request->namaKos;
        $favorit->alamat = $request->alamat;
        $favorit->cerita = $request->cerita;
        $favorit->disetujui = $request->disetujui;
        $favorit->fasKamar = $request->fasKamar;
        $favorit->fasKamarmandi = $request->fasKamarmandi;
        $favorit->pemilikId = $request->pemilikId;
        $favorit->fasParkir = $request->fasParkir;
        $favorit->fasUmum = $request->fasUmum;
        $favorit->harga = $request->harga;
        $favorit->hargaPromo = $request->hargaPromo;
        $favorit->isPromo = $request->isPromo;
        $favorit->jenis = $request->jenis;
        $favorit->lokasi = $request->lokasi;
        $favorit->jlhKamar = $request->jlhKamar;
        $favorit->kecamatan = $request->kecamatan;
        $favorit->peraturan = $request->peraturan;
        $favorit->spektipekamar = $request->spektipekamar;
        $favorit->gambarKos = $request->gambarKos;
        $favorit->tipe = $request->tipe;
        $favorit->emailPenambah = $request->emailPenambah;
        $favorit->save();
        return $this->success($favorit, 'update data success');
    }

    public function show($id)
    {
        $favorit = Favorit::findOrFail($id);
        $favorit->gambar_url = asset('storage/images/' . $favorit->gambarKos);
        return $this->success($favorit, 'get record success');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($namaKos, $emailPenambah)
    {
        try {
            // Find the favorit record based on namaKos and emailPenambah
            $favorit = Favorit::where('namaKos', $namaKos)
                ->where('emailPenambah', $emailPenambah)
                ->first();

            if (!$favorit) {
                // If the favorit record is not found, return an error response
                return $this->error($favorit->errors()->toArray(), 'Favorit record not found', 404);
            }

            // Delete the favorit record
            $favorit->delete();

            return $this->success(null, 'Delete data success.');
        } catch (\Exception $e) {
            return $this->error($favorit->errors()->toArray(), ' An error occurred while deleting the favorit', 500);
        }
    }

}
