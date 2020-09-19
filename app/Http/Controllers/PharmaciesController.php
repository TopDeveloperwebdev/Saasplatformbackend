<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pharmacies;
use Auth;
use Illuminate\Support\Facades\DB;

class PharmaciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $instance_id = $request->get('instance_id');

        if ($instance_id == 0) {
            $res = DB::select("SELECT * from `pharmacies` order by id DESC ");
        } else {
            //  $res = Pharmacies::where('instance_id', $data['instance_id'])->orderBy('id', 'DESC')->paginate($data['pagination']);
            $res = DB::select("SELECT * from `pharmacies` where instance_id like $instance_id  order by id DESC ");
        }

        return $res;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->get('data'));
        //file save
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = 'file_storage/';
            $originalFile = $file->getClientOriginalName();
            $filename = strtotime(date('Y-m-d h:i:s')) . $originalFile;
            $file->move($destinationPath, $filename);
            $data->pharmacyLogo = url('/') . '/file_storage/' . $filename;
        }

        $Array = json_decode(json_encode($data), true);
        return Pharmacies::create($Array);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = json_decode($request->get('data'));
        //file save

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = 'file_storage/';
            $originalFile = $file->getClientOriginalName();
            $filename = strtotime(date('Y-m-d h:i:s')) . $originalFile;
            $file->move($destinationPath, $filename);

            $data->pharmacyLogo = url('/') . '/file_storage/' . $filename;
        }

        $Array = json_decode(json_encode($data), true);

        Pharmacies::whereId($Array['id'])->update($Array);
        return $Array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $res = Pharmacies::where('id', $request->get('id'))->delete();
        return $res;
    }
}
