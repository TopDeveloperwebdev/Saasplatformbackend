<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medication;
use Auth;
use Illuminate\Support\Facades\DB;

class MedicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $instance_id = $data['instance_id'];
        $ingredients = DB::select("SELECT ingredients from `ingredients` order by id ASC ");
        

        $medications = [];
        if ($instance_id == 0) {
            $medications = DB::select("SELECT id , medicationName , ingredients , packaging, (SELECT COUNT(DISTINCT patient)  FROM `orders` WHERE orders.orderMedications LIKE  CONCAT('%',medications.medicationName,'%') ) AS patientsCount , (SELECT COUNT(DISTINCT user_id)  FROM `orders` WHERE orders.orderMedications LIKE  CONCAT('%',medications.medicationName,'%') ) AS ordersCount  FROM medications");
        } else {

            $medications = DB::select("SELECT id , medicationName , ingredients , packaging, (SELECT COUNT(DISTINCT patient)  FROM `orders` WHERE orders.orderMedications LIKE  CONCAT('%',medications.medicationName,'%') ) AS patientsCount , (SELECT COUNT(DISTINCT user_id)  FROM `orders` WHERE orders.orderMedications LIKE  CONCAT('%',medications.medicationName,'%') ) AS ordersCount  FROM medications where instance_id like $instance_id  order by id DESC ");
        }

        $ret = array(
            "medications" => $medications,
            "ingredients" => $ingredients,         
        );
        return $ret;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Medication::pluck('title', 'id');
        return view('admin.Medication.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        unset($data['ordersCount']);
         unset($data['patientsCount']);
        return Medication::create($data);
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
        $data = $request->all();
        unset($data['ordersCount']);
        unset($data['patientsCount']);
        return Medication::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Medication::where('id', $request->get('id'))->delete();
        return $res;
    }
}
