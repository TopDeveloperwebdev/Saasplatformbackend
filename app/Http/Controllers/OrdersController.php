<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Comment;
use Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $instance_id = $request->get('instance_id');
        $user_id = $request->get('user_id');
        $patients = [];

        $medications = DB::select("SELECT medicationName from `medications` order by medicationName ASC ");



        if ($instance_id == 0) {
            $patients = DB::select("SELECT * from `patients` order by id DESC ");
            $orders = DB::select("SELECT * FROM orders LEFT JOIN app_user ON orders.user_id LIKE app_user.id order by orders.created_at DESC");
        } else {
            //  $res = Patient::where('instance_id', $data['instance_id'])->orderBy('id', 'DESC')->paginate($data['pagination']);
            $patients = DB::select("SELECT * from `patients` where instance_id like $instance_id  order by id DESC ");
            
            $orders = DB::select("SELECT * FROM orders LEFT JOIN app_user ON orders.user_id LIKE app_user.id WHERE app_user.instance_id LIKE $instance_id order by orders.created_at DESC");
        }
        
        $ret = array(
            "patients" => $patients,
            "medications" => $medications,
            "orders" => $orders
        );
        return $ret;
    }
    public function getDetail(Request $request)
    {
        $orderId = $request->get('orderId');
        $orderTemp = DB::select("SELECT * FROM orders LEFT JOIN app_user ON orders.user_id LIKE app_user.id where orderId like '$orderId'");
        $ret = [];
        if (count($orderTemp)) {
            $order = $orderTemp[0];

            $patient = DB::select("SELECT * from `patients` where id like '$order->patient'");
            $doctor = DB::select("SELECT * from `family_doctors` where doctorName like '$order->doctor'");
            $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$order->pharmacy'");
            $user = DB::select("SELECT name , id from `app_user` where id like '$order->user_id'");

            $patientId = $patient[0]->id;

            $lastOrderTemp = DB::select("SELECT * FROM orders WHERE patient LIKE $patientId ORDER BY created_at DESC  LIMIT 1");
            $lastOrder = $lastOrderTemp[0];
            $lastUser = DB::select("SELECT name from `app_user` where id like '$lastOrder->user_id'");
            $instance = DB::select("SELECT * from `instances` where id like '$order->instance_id'");
            $orderMedications = json_decode($order->orderMedications);
            $Medications = DB::table('medications')->whereIn('medicationName', $orderMedications)->get();

            $commentList = DB::select("SELECT * from `comments` where orderId like '$order->orderId'");
            $ret = array(
                "patient" => $patient,
                "doctor" => $doctor,
                "pharmacy" => $pharmacy,
                "user" => $user,
                "orderMedications" => $Medications,
                "order" => $order,
                "lastUser" => $lastUser,
                "lastOrder" => $lastOrder,
                "instance" => $instance ,
                "commentList" => $commentList
            );
        }



        return $ret;
    }

    function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numbers = "0123456789";

        $lettersLength = strlen($letters);
        $numbersLength = strlen($numbers);
        $randomString1 = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString1 .= $letters[rand(0, $lettersLength - 1)];
        }
        $randomString2 = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString2 .= $letters[rand(0, $lettersLength - 1)];
        }
        $randomNumber = '';
        for ($i = 0; $i < 3; $i++) {
            $randomNumber .= $numbers[rand(0, $numbersLength - 1)];
        }

        return $randomString1.'-'.$randomNumber.'-'.$randomString2;
    }

    /**
     * Store a newly created Order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['orderId'] = $this->generateRandomString(10);
        return Order::create($data);
    }

    public function submit(Request $request)
    {
      
        $data = $request->all();   
        return Comment::create($data);
    }
    
    /**
     * Update the specified Order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        return Order::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Order::where('id', $request->get('id'))->delete();
        return $res;
    }
}
