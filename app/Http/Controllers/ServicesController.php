<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Auth;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the Service.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();      
        $res = DB::select("SELECT * from `services` order by id DESC ");
        return $res;
    }

    /**
     * Show the form for creating a new Service.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Service::pluck('title', 'id');
        return view('admin.Service.create', compact('categories'));
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        return Service::create($data);
    }


    /**
     * Update the specified Service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        return Service::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Service::where('id', $request->get('id'))->delete();
        return $res;
    }
}
