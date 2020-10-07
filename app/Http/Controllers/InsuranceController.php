<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Insurance;
use Auth;
use Illuminate\Support\Facades\DB;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the Insurance.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $res = DB::select("SELECT * from `insurances` order by id DESC ");
        return $res;
    }

    /**
     * Show the form for creating a new Insurance.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Insurance::pluck('title', 'id');
        return view('admin.Insurance.create', compact('categories'));
    }

    /**
     * Store a newly created Insurance in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        return Insurance::create($data);
    }


    /**
     * Update the specified Insurance in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        return Insurance::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Insurance from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Insurance::where('id', $request->get('id'))->delete();
        return $res;
    }
}
