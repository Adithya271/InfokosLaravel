<?php

namespace App\Http\Controllers;


use App\Models\Booking;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $namaKos = $request->namaKos;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';
        $pencariId = $request->pencariId;

        $booking = Booking::where(function ($f) use ($namaKos, $pencariId) {
            if ($namaKos && $namaKos != '' && $namaKos != 'null') {
                $f->where('namaKos', 'LIKE', '%' . $namaKos . '%');
            }

            if ($pencariId && $pencariId != '' && $pencariId != 'null') {
                $f->where('pencariId', $pencariId);
            }
        })
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        $data['paging'] = new PaginationResource($booking);
        $data['records'] = $booking->items();

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
    public function store(BookingRequest $request)
    {
        $booking = new Booking();

        // Handle image upload
        if ($request->hasFile('gambarKos')) {
            $image = $request->file('gambarKos');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $booking->gambarKos = str_replace('"', '', $filename);
        }
        $booking->namaKos = $request->namaKos;
        $booking->alamat = $request->alamat;
        $booking->cerita = $request->cerita;
        $booking->fasKamar = $request->fasKamar;
        $booking->fasKamarmandi = $request->fasKamarmandi;
        $booking->disetujui = $request->disetujui;
        $booking->fasParkir = $request->fasParkir;
        $booking->fasUmum = $request->fasUmum;
        $booking->harga = $request->harga;
        $booking->hargaPromo = $request->hargaPromo;
        $booking->isPromo = $request->isPromo;
        $booking->pemilikId = $request->pemilikId;
        $booking->jenis = $request->jenis;
        $booking->lokasi = $request->lokasi;
        $booking->jlhKamar = $request->jlhKamar;
        $booking->namaKecamatan = $request->namaKecamatan;
        $booking->peraturan = $request->peraturan;
        $booking->spektipekamar = $request->spektipekamar;
        $booking->tipe = $request->tipe;
        $booking->gambarKos = $request->gambarKos;
        $booking->pencariId = $request->pencariId;
        $booking->save();
        return $this->success($booking, 'save data success');
    }

    public function update(BookingRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Handle image update
        if ($request->hasFile('gambarKos')) {
            $image = $request->file('gambarKos');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $booking->gambarKos = str_replace('"', '', $filename);
        }
        $booking->namaKos = $request->namaKos;
        $booking->alamat = $request->alamat;
        $booking->cerita = $request->cerita;
        $booking->disetujui = $request->disetujui;
        $booking->fasKamar = $request->fasKamar;
        $booking->fasKamarmandi = $request->fasKamarmandi;
        $booking->pemilikId = $request->pemilikId;
        $booking->fasParkir = $request->fasParkir;
        $booking->fasUmum = $request->fasUmum;
        $booking->harga = $request->harga;
        $booking->hargaPromo = $request->hargaPromo;
        $booking->isPromo = $request->isPromo;
        $booking->jenis = $request->jenis;
        $booking->lokasi = $request->lokasi;
        $booking->jlhKamar = $request->jlhKamar;
        $booking->kecamatan = $request->kecamatan;
        $booking->peraturan = $request->peraturan;
        $booking->spektipekamar = $request->spektipekamar;
        $booking->gambarKos = $request->gambarKos;
        $booking->tipe = $request->tipe;
        $booking->pencariId = $request->pencariId;
        $booking->save();
        return $this->success($booking, 'update data success');
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->gambar_url = asset('storage/images/' . $booking->gambarKos);
        return $this->success($booking, 'get record success');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($namaKos, $pencariId)
    {
        try {
            // Find the favorit record based on namaKos and pencariId
            $booking = Booking::where('namaKos', $namaKos)
                ->where('pencariId', $pencariId)
                ->first();

            if (!$booking) {
                // If the booking record is not found, return an error response
                return $this->error($booking->errors()->toArray(), 'booking record not found', 404);
            }

            // Delete the booking record
            $booking->delete();

            return $this->success(null, 'Delete data success.');
        } catch (\Exception $e) {
            return $this->error($booking->errors()->toArray(), ' An error occurred while deleting the favorit', 500);
        }
    }
}
