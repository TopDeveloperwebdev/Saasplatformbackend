<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Auth;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $res = DB::select("SELECT * from `permissions` order by id DESC ");
        return $res;
    }

  

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        return Permission::create($data);
    }


    /**
     * Update the specified Permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        return Permission::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Permission::where('id', $request->get('id'))->delete();
        return $res;
    }
}
