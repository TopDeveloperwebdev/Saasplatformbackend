<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Auth;
use Illuminate\Support\Facades\DB;

class PatientsController extends Controller
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
        $patients = [];
        $services = DB::select("SELECT services from `services` order by services ASC ");
        $resources = DB::select("SELECT resources from `resources` order by resources ASC ");
        $family_doctors = DB::select("SELECT doctorName from `family_doctors` order by doctorName ASC ");
        $insurances = DB::select("SELECT insurances from `insurances` order by insurances ASC ");
        $pharmacies = DB::select("SELECT pharmacyName from `pharmacies` order by pharmacyName ASC ");
        $instances = DB::select("SELECT t1.* , t2.email , t2.name FROM instances AS t1 LEFT JOIN app_user AS t2 ON t1.id LIKE t2.instance_id WHERE t1.id like $instance_id  and t2.isOwner like 1");
        $instanceNames = DB::select("SELECT  id , instanceName from `instances` ");

        if ($instance_id == 0) {
            $patients = DB::select("SELECT * from `patients` order by id DESC ");
            $users = DB::select("SELECT * from `app_user` order by id DESC ");
        } else {
            //  $res = Patient::where('instance_id', $data['instance_id'])->orderBy('id', 'DESC')->paginate($data['pagination']);

            $patients = DB::select("SELECT * from `patients` where instance_id like $instance_id  order by id DESC ");
            $users = DB::select("SELECT * from `app_user` where instance_id like $instance_id  order by id DESC ");
        }
        $documents = DB::select("SELECT * FROM documents");

        $folders = DB::select("SELECT * from `carefolders` where instance_id like $instance_id order by id DESC");
        $caremanagers = DB::select("SELECT * from `caremanagers` order by ansprechpartner DESC");
        $ret = array(
            "patients" => $patients,
            "services" => $services,
            "resources" => $resources,
            "family_doctors" => $family_doctors,
            "insurances" => $insurances,
            "pharmacies" => $pharmacies,
            "users" => $users,
            "documents" => $documents,
            "folders" => $folders,
            "instances" => $instances,
            "instanceNames" => $instanceNames,
            "caremanagers" => $caremanagers
        );
        return $ret;
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
            $data->picture = url('/') . '/file_storage/' . $filename;
        }

        $Array = json_decode(json_encode($data), true);
        return Patient::create($Array);
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

            $data->picture = url('/') . '/file_storage/' . $filename;
        }

        $Array = json_decode(json_encode($data), true);

        Patient::whereId($Array['id'])->update($Array);
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


        $res = Patient::where('id', $request->get('id'))->delete();
        return $res;
    }
}
