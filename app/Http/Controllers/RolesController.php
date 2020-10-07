<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Auth;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
     
        $roles = DB::select("SELECT * from `roles` where role not like 'super administrator' order by id DESC ");
        $permissions = DB::select("SELECT `permissions` from `permissions`  order by id DESC ");
        $ret = array(
            "roles" => $roles,
            "permissions" => $permissions
        );
        return $ret;
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        return Role::create($data);
    }


    /**
     * Update the specified Role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        return Role::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Role::where('id', $request->get('id'))->delete();
        return $res;
    }
}
