<?php

namespace App\Http\Controllers;


use App\Models\Penginapan;
use App\Models\Image;
use App\Http\Requests\PenginapanRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class PenginapanController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?: 10;
        $namaKecamatan = $request->namaKecamatan;
        $id = $request->pemilikId;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $query = Penginapan::with('kecamatan', 'user_pemilik')
            ->where(function ($query) use ($namaKecamatan) {
                if ($namaKecamatan && $namaKecamatan != '' && $namaKecamatan != 'null') {
                    $query->whereHas('kecamatan', function ($f) use ($namaKecamatan) {
                        $f->where('namaKecamatan', 'LIKE', '%' . $namaKecamatan . '%');
                    });
                }
            })
            ->orderBy($orderCol, $orderType);

        if ($id) {
            $query->where('pemilikId', $id);
        }

        $penginapan = $query->paginate($limit);

        if ($request->wantsJson()) {
            return $this->success($penginapan, 'get records penginapan success');
        }

        return view('kos', compact('penginapan'));
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');


        $records = Penginapan::where('namaKos', 'like', '%' . $searchQuery . '%')->get();


        return view('kos', compact('records', 'searchQuery'));
    }

    public function getAllKos(Request $request)
    {
        $limit = $request->limit;
        $namaKecamatan = $request->kecamatan;
        $id = $request->pemilikId;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';


        $penginapan = Penginapan::with('kecamatan', 'user_pemilik')
            ->where(function ($query) use ($namaKecamatan) {
                if ($namaKecamatan && $namaKecamatan != '' && $namaKecamatan != 'null') {

                    $query->whereHas('kecamatan', function ($f) use ($namaKecamatan) {
                        $f->where('namaKecamatan', 'LIKE', '%' . $namaKecamatan . '%');
                    });
                }
            })


            ->where('disetujui', '0')

            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        if ($id) {
            $query->where('pemilikId', $id);
        }


        $data['paging'] = new PaginationResource($penginapan);
        $data['records'] = $penginapan->items();

        return $this->success($data, 'get records data success');
    }


    public function getPromoKos(Request $request)
    {
        $limit = $request->limit;
        $namaKecamatan = $request->kecamatan;
        $id = $request->pemilikId;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $penginapan = Penginapan::with('kecamatan', 'user_pemilik')
            ->where(function ($query) use ($namaKecamatan) {
                if ($namaKecamatan && $namaKecamatan != '' && $namaKecamatan != 'null') {

                    $query->whereHas('kecamatan', function ($f) use ($namaKecamatan) {
                        $f->where('namaKecamatan', 'LIKE', '%' . $namaKecamatan . '%');
                    });
                }
            })
            ->where('disetujui', '0')
            ->where('isPromo', '0')
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        if ($id) {
            $query->where('pemilikId', $id);
        }

        $data['paging'] = new PaginationResource($penginapan);
        $data['records'] = $penginapan->items();

        return $this->success($data, 'get records data success');
    }

    public function cariKos(Request $request)
    {
        $limit = $request->limit;
        $namaKos = $request->namaKos;
        $id = $request->pemilikId;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';
        $kecamatan = $request->kecamatan;


        $penginapan = Penginapan::with('kecamatan', 'user_pemilik')
            ->where(function ($query) use ($kecamatan) {
                if ($kecamatan && $kecamatan != '' && $kecamatan != 'null') {
                    $query->whereHas('kecamatan', function ($f) use ($kecamatan) {
                        $f->where('namaKecamatan', 'LIKE', '%' . $kecamatan . '%');
                    });
                }
            })
            ->where(function ($query) use ($namaKos) {
                if ($namaKos && $namaKos != '' && $namaKos != 'null') {
                    $query->where('namaKos', 'LIKE', '%' . $namaKos . '%')
                        ->orWhere('alamat', 'LIKE', '%' . $namaKos . '%')
                        ->orWhereHas('kecamatan', function ($f) use ($namaKos) {
                            $f->where('namaKecamatan', 'LIKE', '%' . $namaKos . '%');
                        });
                }
            })
            ->where('disetujui', '0')
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        if ($id) {
            $query->where('pemilikId', $id);
        }

        $data['paging'] = new PaginationResource($penginapan);
        $data['records'] = $penginapan->items();

        return $this->success($data, 'get records data success');
    }

    public function belumPublish(Request $request)
    {
        $limit = $request->limit;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';
        $pemilikId = $request->pemilikId;
        $disetujui = $request->disetujui;

        $penginapan = Penginapan::where(function ($f) use ($pemilikId, $disetujui) {
            if ($pemilikId && $pemilikId != '' && $pemilikId != 'null') {
                $f->where('pemilikId', 'LIKE', '%' . $pemilikId . '%');
            }

            if ($disetujui && $disetujui != '' && $disetujui != 'null') {
                $f->where('disetujui', $disetujui);
            }
        })
            ->where('disetujui', '1')
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        $data['paging'] = new PaginationResource($penginapan);
        $data['records'] = $penginapan->items();

        return $this->success($data, 'get records data success');
    }

    public function sudahPublish(Request $request)
    {
        $limit = $request->limit;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';
        $pemilikId = $request->pemilikId;
        $disetujui = $request->disetujui;

        $penginapan = Penginapan::where(function ($f) use ($pemilikId, $disetujui) {
            if ($pemilikId && $pemilikId != '' && $pemilikId != 'null') {
                $f->where('pemilikId', 'LIKE', '%' . $pemilikId . '%');
            }

            if ($disetujui && $disetujui != '' && $disetujui != 'null') {
                $f->where('disetujui', $disetujui);
            }
        })
            ->where('disetujui', '0')
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        $data['paging'] = new PaginationResource($penginapan);
        $data['records'] = $penginapan->items();

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
    public function store(PenginapanRequest $request)
    {
        $penginapan = new Penginapan();

        // Handle image upload
        if ($request->hasFile('filename')) {
            $image = $request->file('filename');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $filename);
            $penginapan->gambarKos = basename($path);
        }

        //  code untuk save Penginapan data
        $penginapan->namaKos = $request->namaKos;
        $penginapan->alamat = $request->alamat;
        $penginapan->cerita = $request->cerita;
        $penginapan->disetujui = $request->disetujui;
        $penginapan->fasKamar = $request->fasKamar;
        $penginapan->fasKamarmandi = $request->fasKamarmandi;
        $penginapan->fasParkir = $request->fasParkir;
        $penginapan->fasUmum = $request->fasUmum;
        $penginapan->harga = $request->harga;
        $penginapan->hargaPromo = $request->hargaPromo;
        $penginapan->isPromo = $request->isPromo;
        $penginapan->jenis = $request->jenis;
        $penginapan->lokasi = $request->lokasi;
        $penginapan->jlhKamar = $request->jlhKamar;
        $penginapan->namaKecamatan = $request->namaKecamatan;
        $penginapan->pemilikId = $request->pemilikId;
        $penginapan->peraturan = $request->peraturan;
        $penginapan->spektipekamar = $request->spektipekamar;
        $penginapan->gambarKos = $request->gambarKos;
        $penginapan->tipe = $request->tipe;
        $penginapan->save();

        return $this->success($penginapan, 'tambah data success');
    }


    public function update(PenginapanRequest $request, $id)
    {
        $penginapan = Penginapan::findOrFail($id);

        // Handle image update
        if ($request->hasFile('filename')) {
            $image = $request->file('filename');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $filename);
            $penginapan->gambarKos = basename($path);
        }
        $penginapan->namaKos = $request->namaKos;
        $penginapan->alamat = $request->alamat;
        $penginapan->cerita = $request->cerita;
        $penginapan->disetujui = $request->disetujui;
        $penginapan->fasKamar = $request->fasKamar;
        $penginapan->fasKamarmandi = $request->fasKamarmandi;
        $penginapan->fasParkir = $request->fasParkir;
        $penginapan->fasUmum = $request->fasUmum;
        $penginapan->harga = $request->harga;
        $penginapan->hargaPromo = $request->hargaPromo;
        $penginapan->isPromo = $request->isPromo;
        $penginapan->jenis = $request->jenis;
        $penginapan->lokasi = $request->lokasi;
        $penginapan->jlhKamar = $request->jlhKamar;
        $penginapan->namaKecamatan = $request->namaKecamatan;
        $penginapan->pemilikId = $request->pemilikId;
        $penginapan->peraturan = $request->peraturan;
        $penginapan->spektipekamar = $request->spektipekamar;
        $penginapan->gambarKos = $request->gambarKos;
        $penginapan->tipe = $request->tipe;
        $penginapan->save();
        return $this->success($penginapan, 'update data success');
    }



    public function setuju($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $penginapan->disetujui = '0';
        $penginapan->save();

        return redirect()->back()->with('success', 'Data disetujui.');
    }

    public function tolak($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $penginapan->disetujui = '1';
        $penginapan->save();

        return redirect()->back()->with('success', 'Data ditolak.');
    }


    public function show($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $penginapan->gambar_url = asset('storage/images/' . $penginapan->gambarKos);
        return $this->success($penginapan, 'get record success');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penginapan::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
