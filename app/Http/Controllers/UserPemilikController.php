<?php

namespace App\Http\Controllers;

use App\Models\UserPemilik;
use App\Http\Requests\UserPemilikRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserPemilikController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?: 10;
        $email = $request->email;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $userpemilik = UserPemilik::where(function ($f) use ($email) {
            if ($email && $email != '' && $email != 'null') {
                $f->where('email', 'LIKE', '%' . $email . '%');
            }
        })

            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        if ($request->wantsJson()) {
            return $this->success($userpemilik, 'get records data success');
        }

        return view('pemilik', compact('userpemilik'));
    }

    public function getProfile(Request $request, $id)
    {

        $limit = $request->limit ?: 10;
        $id = $id;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $userpemilik = UserPemilik::where(function ($f) use ($id) {
            if ($id && $id != '' && $id != 'null') {
                $f->where('id', 'LIKE', '%' . $id . '%');
            }
        })

            ->orderBy($orderCol, $orderType)
            ->paginate($limit);

        if ($request->wantsJson()) {
            return $this->success($userpemilik, 'get records data success');
        }
    }

    public function updateProfilePemilik(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'nullable|string|max:255',
            'nomorHp' => 'nullable|string|max:15',
            'profilGambar' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->toArray(), 'Validation Error', 400);
        }

        $userpemilik = UserPemilik::findOrFail($id);

        if ($request->hasFile('profilGambar')) {
            $image = $request->file('profilGambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $userpemilik->profilGambar = str_replace('"', '', $filename);
        }


        if ($request->has('nama')) {
            $userpemilik->nama = $request->input('nama');
        }
        if ($request->has('nomorHp')) {
            $userpemilik->nomorHp = $request->input('nomorHp');
        }
        if ($request->has('profilGambar')) {
            $userpemilik->profilGambar = $request->input('profilGambar');
        }

        $userpemilik->save();

        return $this->success($userpemilik, 'update profil success');
    }


    public function updateRekeningPemilik(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'namaBank' => 'required|string|max:255',
            'noRek' => 'required|integer',
            'atasNama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->toArray(), 'Validation Error', 400);
        }

        $userpemilik = UserPemilik::findOrFail($id);

        $userpemilik->namaBank = $request->input('namaBank');
        $userpemilik->noRek = $request->input('noRek');
        $userpemilik->atasNama = $request->input('atasNama');
        $userpemilik->save();
        return $this->success($userpemilik, 'update data success');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');


        $records = UserPemilik::where('nama', 'like', '%' . $searchQuery . '%')->get();


        return view('pemilik', compact('records', 'searchQuery'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tambah_pemilik');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPemilikRequest $request)
    {
        $userpemilik = new UserPemilik();
        // Handle image upload
        if ($request->hasFile('profilGambar')) {
            $image = $request->file('profilGambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $userpemilik->profilGambar = $filename;
        }
        $userpemilik->email = $request->email;
        $userpemilik->password = Hash::make($request->password);
        $userpemilik->nama = $request->nama;
        $userpemilik->nomorHp = $request->nomorHp;
        $userpemilik->email_verified_at = $request->email_verified_at;
        $userpemilik->role = 'pemilik';
        $userpemilik->save();

        session()->flash('tambah_success', 'Data berhasil ditambahkan');
        return $this->success($userpemilik, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userpemilik = Userpemilik::findOrFail($id);
        return $this->success($userpemilik, 'get record success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $userpemilik = UserPemilik::findOrFail($id);
        return view('edit_pemilik', compact('userpemilik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserPemilikRequest $request, $id)
    {
        $userpemilik = UserPemilik::findOrFail($id);
        // Handle image upload
        if ($request->hasFile('profilGambar')) {
            $image = $request->file('profilGambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $userpemilik->profilGambar = $filename;
        }
        $userpemilik->email = $request->email;
        $userpemilik->password = Hash::make($request->password);
        $userpemilik->nama = $request->nama;
        $userpemilik->nomorHp = $request->nomorHp;
        $userpemilik->email_verified_at = $request->email_verified_at;
        $userpemilik->role = 'pemilik';
        $userpemilik->save();

        session()->flash('edit_success', 'Data berhasil diedit');
        return redirect('/userpemilik')->with('success', 'Update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserPemilik::findOrFail($id)->delete();
        session()->flash('delete_success', 'Data berhasil dihapus');
        return $this->success(null, 'delete data success');
    }
}
