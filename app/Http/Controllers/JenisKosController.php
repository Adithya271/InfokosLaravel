<?php

namespace App\Http\Controllers;
use App\Models\Jeniskos;
use App\Http\Requests\JenisKosRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

class JenisKosController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $jenis = $request->jenis;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $jeniskos = Jeniskos::where(function ($f) use ($jenis) {
            if ($jenis && $jenis != '' && $jenis != 'null') {
                $f->where('jenis', 'LIKE', '%' . $jenis . '%');
            }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);

        $data['paging'] = new PaginationResource($jeniskos);
        $data['records'] = $jeniskos->items();

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
    public function store(JenisKosRequest $request)
    {
        $jeniskos = new Jeniskos();
        $jeniskos->jenis = $request->jenis;
        $jeniskos->save();
        return $this->success($jeniskos, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jeniskos = Jeniskos::findOrFail($id);
        return $this->success($jeniskos, 'get record success');
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
    public function update(JenisKosRequest $request, $id)
    {

        $jeniskos = Jeniskos::findOrFail($id);
        $jeniskos->jenis = $request->jenis;
        $jeniskos->save();
        return $this->success($jeniskos, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Jeniskos::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
