<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Http\Requests\IklanRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class IklanController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?: 10;
        $gambar = $request->gambar;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $iklan = Iklan::where(function ($f) use ($gambar) {
            if ($gambar && $gambar != '' && $gambar != 'null') {
                $f->where('gambar', 'LIKE', '%' . $gambar . '%');
            }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);

        $data['paging'] = new PaginationResource($iklan);
        $data['records'] = $iklan->items();

        if ($request->wantsJson()) {
        return $this->success($data, 'get records data success');
    }

        return view('iklan', $data);


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
    public function store(IklanRequest $request)
    {
        $iklan = new Iklan();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $iklan->gambar = $filename;
        }

        $iklan->save();
        return $this->success($iklan, 'save data success');
    }

    public function update(IklanRequest $request, $id)
    {
        $iklan = Iklan::findOrFail($id);

        // Handle image update
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $iklan->gambar = $filename;
        }

        $iklan->save();
        return $this->success($iklan, 'update data success');
    }

    public function show($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->gambar_url = asset('storage/images/' . $iklan->gambar);
        return $this->success($iklan, 'get record success');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Iklan::findOrFail($id)->delete();
        session()->flash('delete_success', 'Data berhasil dihapus');
        return $this->success(null, 'delete data success');
    }
}
