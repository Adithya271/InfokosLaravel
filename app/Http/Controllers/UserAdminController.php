<?php

namespace App\Http\Controllers;

use App\Models\UserAdmin;
use App\Http\Requests\UserAdminRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $email = $request->email;
        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $userAdmin = Useradmin::where(function ($f) use ($email) {
            if ($email && $email != '' && $email != 'null') {
                $f->where('email', 'LIKE', '%' . $email . '%');
            }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);

        $data['paging'] = new PaginationResource($userAdmin);
        $data['records'] = $userAdmin->items();

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
    public function store(UserAdminRequest $request)
    {
        $userAdmin = new Useradmin();
        $userAdmin->email = $request->email;
        $userAdmin->password = Hash::make($request->password);
        $userAdmin->email_verified_at = $request->email_verified_at;
        $userAdmin->role = 'admin';
        $userAdmin->save();
        return $this->success($userAdmin, 'save data success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userAdmin = Useradmin::findOrFail($id);
        return $this->success($userAdmin, 'get record success');
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
    public function update(UserAdminRequest $request, $id)
    {

        $userAdmin = Useradmin::findOrFail($id);
        $userAdmin->email = $request->email;
        $userAdmin->password = Hash::make($request->password);
        $userAdmin->email_verified_at = $request->email_verified_at;
        $userAdmin->role = 'admin';
        $userAdmin->save();
        return $this->success($userAdmin, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Useradmin::findOrFail($id)->delete();
        return $this->success(null, 'delete data success');
    }
}
