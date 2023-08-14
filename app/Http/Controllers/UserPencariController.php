<?php

namespace App\Http\Controllers;

use App\Models\UserPencari;
use App\Http\Requests\UserPencariRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserPencariController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->limit ?: 10;
        $email = $request->email;
        $orderCol = $request->order_col ?: 'id';
        $orderType = $request->order_type ?: 'asc'; 

        $userpencari = UserPencari::where(function ($f) use ($email) {
            if ($email && $email != '' && $email != 'null') {
                $f->where('email', 'LIKE', '%' . $email . '%');
            }
        })
            ->orderBy($orderCol, $orderType)
            ->paginate($limit);


        if ($request->wantsJson()) {
            return $this->success($userpencari, 'get records data success');
        }

        return view('pencari', compact('userpencari'));
    }


    public function getProfile(Request $request)
    {

        $userId = $request->user()->id;


        \Log::info("User ID: " . $userId);


        $userPencari = UserPencari::findOrFail($userId);

        return $this->success($userPencari, 'get profile data success');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $limit = $request->limit ?: 10;

        $userpencari = UserPencari::where('nama', 'like', '%' . $searchQuery . '%')
            ->paginate($limit);

        if ($request->wantsJson()) {
            return $this->success($userpencari, 'get records data success');
        }

        return view('pencari', compact('userpencari', 'searchQuery'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tambah_pencari');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function updateProfilePencari(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'nama' => 'required|string|max:255',
            'nomorHp' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->toArray(), 'Validation Error', 400);
        }

        $userPencari = UserPencari::findOrFail($id);

        // Handle image upload if provided
        if ($request->hasFile('profilGambar')) {
            $image = $request->file('profilGambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $userPencari->profilGambar = str_replace('"', '', $filename);
        }

        // Update other fields
        $userPencari->nama = $request->input('nama');
        $userPencari->nomorHp = $request->input('nomorHp');
        $userPencari->profilGambar = $request->input('profilGambar');

        $userPencari->save();

        return $this->success($userPencari, 'update data success');
    }


    public function store(UserPencariRequest $request)
    {
        $userpencari = new Userpencari();
        // Handle image upload
        if ($request->hasFile('profilGambar')) {
            $image = $request->file('profilGambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $userpencari->profilGambar = $filename;
        }
        $userpencari->email = $request->email;
        $userpencari->password = Hash::make($request->password);
        $userpencari->nama = $request->nama;
        $userpencari->nomorHp = $request->nomorHp;
        $userpencari->email_verified_at = $request->email_verified_at;
        $userpencari->role = 'pencari';
        $userpencari->save();
        return $this->success($userpencari, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userpencari = UserPencari::findOrFail($id);
        return $this->success($userpencari, 'get record success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $userpencari = UserPencari::findOrFail($id);
        return view('edit_pencari', compact('userpencari'));
    }

    public function update(UserPencariRequest $request, $id)
    {
        $userpencari = UserPencari::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('profilGambar')) {
            $image = $request->file('profilGambar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $userpencari->profilGambar = $filename;
        }

        // Only update password if a new one is provided
        if ($request->has('password')) {
            $userpencari->password = Hash::make($request->password);
        }

        $userpencari->email = $request->email;
        $userpencari->nama = $request->nama;
        $userpencari->nomorHp = $request->nomorHp;
        $userpencari->email_verified_at = $request->email_verified_at;
        $userpencari->role = 'pencari';
        $userpencari->save();

        return redirect('/userpencari')->with('success', 'Update data success');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserPencari::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
