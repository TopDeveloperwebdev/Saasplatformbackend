<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Comment;
use App\Trigger;
use Auth;
use App\emailtemplate;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\Mail\NewArrivals;
use App\Message;
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
        $patients = [];

        $medications = DB::select("SELECT medicationName from `medications` where instance_id like $instance_id order by medicationName ASC ");



        if ($instance_id == 0) {
            $patients = DB::select("SELECT * from `patients` order by id DESC ");
            $orders = DB::select("SELECT * FROM orders  order by orders.created_at DESC");
        } else {
            //  $res = Patient::where('instance_id', $data['instance_id'])->orderBy('id', 'DESC')->paginate($data['pagination']);
            $patients = DB::select("SELECT * from `patients` where instance_id like $instance_id  order by id DESC ");

            $orders = DB::select("SELECT * FROM orders  WHERE orders.user_id LIKE $instance_id order by orders.created_at DESC");
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
            $user = DB::select("SELECT name , id , userAvatar from `app_user` where id like '$order->user_id'");

            $patientId = $patient[0]->id;

            $lastOrderTemp = DB::select("SELECT * FROM orders WHERE patient LIKE $patientId ORDER BY created_at DESC  LIMIT 1");
            $lastOrder = $lastOrderTemp[0];
            $lastUser = DB::select("SELECT name ,id, userAvatar from `app_user` where id like '$lastOrder->user_id'");
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
                "instance" => $instance,
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

        return $randomString1 . '-' . $randomNumber . '-' . $randomString2;
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
        $TriggerType = 'User create an Order';
        $data['orderId'] = $this->generateRandomString(10);
        $instance_id = $request->get('user_id');

        $emailTriggerTemp = DB::select("SELECT * FROM `triggers` AS t1 LEFT JOIN emailtemplates AS t2 ON t1.template LIKE t2.title WHERE t1.instance_id LIKE '$instance_id' AND t1.TYPE LIKE '$TriggerType'");    
        $ret = Order::create($data);


        if (count($emailTriggerTemp)) {
            $users = [];
            $emailTrigger = $emailTriggerTemp[0];
            $usergroup = json_decode($emailTrigger->usergroup);
            $patientId = $request->get('patient');

            $patient = DB::select("SELECT * from `patients` where id like '$patientId'");
            if (in_array("Patients", $usergroup) && count($patient)) {
                if ($patient[0]->email && $patient[0]->serviceplan) {
                    array_push($users, $patient[0]->email);
                }
            }
            if (in_array("Pharmacies", $usergroup)) {
                $pharmacyname = $request->get('pharmacy');
                $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$pharmacyname'");
                if (count($pharmacy)) {
                    if ($pharmacy[0]->email && $pharmacy[0]->notifications) {
                        array_push($users, $pharmacy[0]->email);
                    }
                }
            }
            if (in_array("Family doctors", $usergroup)) {
                $doctorName = $request->get('doctor');
                $family_doctors = DB::select("SELECT * from `family_doctors` where doctorName like '$doctorName'");
                if (count($family_doctors)) {
                    if ($family_doctors[0]->email && $family_doctors[0]->notifications) {
                        array_push($users, $family_doctors[0]->email);
                    }
                }
            }
            $content = $emailTrigger->body;
            $public_link = env('PUBLIC_LINK', 'base.mastermedi-1.vautronserver.de/order-detail/');
           
            if (count($patient)) {
                $placeholders = $patient[0];     
                $content =  str_replace("[patient firstname]", $placeholders->firstName, $content);
                $content =  str_replace("[patient lastname]", $placeholders->lastName, $content);
                $content =  str_replace("[patient birthday]", $this->formate_date($placeholders->birthday) , $content);
                $content =  str_replace("[patient insurance]", $placeholders->insurance, $content);
                $content =  str_replace("[patient address]", $placeholders->streetNr, $content);
                $content =  str_replace("[patient phone]", $placeholders->phone1, $content);
                $content =  str_replace("[patient phone]", $placeholders->phone1, $content);
                $content =  str_replace("[oder_id]", $ret->orderId, $content);
                $content =  str_replace("[order_duedate]", $ret->date, $content);
                $content =  str_replace("[order_public_link]", $public_link . $ret->orderId, $content);
                if ($placeholders->instance_id == '0') {
                    $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE '0'");
                    $email = $instanceEmail[0]->email;
                } else {
                    $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE $placeholders->instance_id AND isOwner LIKE 1");
                    $email = $instanceEmail[0]->email;
                }
            }


            $this->sendMail($emailTrigger->title, $content, $users, $email);
        }


        return $ret;
    }
    public function formate_date($dateString){
        $date = '';
     
		if ($dateString) {		
            $date = explode('-',$dateString);            
            $dateStr = $date[2] . '.' . $date[1] . '.' . $date[0];       
		}

		return $dateStr;
    }
    public function sendMail($title, $body, $users, $instanceEmail)
    {
        $message = new Message();
        $message->title = $title;
        $message->body = $body;
        $message->receivers  = json_encode($users);
        $message->delivered = 'YES';
        $message->send_date = Carbon::now();
        $message->save();

        foreach ($users as $user) {
            dispatch(new SendMailJob($user, new NewArrivals($title, $body, $instanceEmail)));
        }

        return response()->json('Mail sent.', 201);
    }
    public function notifyBirthday()
    {
        $now = date("m-d", strtotime(Carbon::now()->addHour()));
        logger($now);
        print_r($now);
        $patients = DB::select("SELECT * FROM patients WHERE birthday LIKE '%$now%'");
        if (count($patients)) {
            $TriggerType = 'Every year on birthdays';


            //Get all messages that their dispatch date is due
            foreach ($patients as $patient) {
                $emailTriggerTemp = DB::select("SELECT * FROM `triggers` AS t1 LEFT JOIN emailtemplates AS t2 ON t1.template LIKE t2.title WHERE t1.instance_id LIKE '$patient->instance_id' AND t1.TYPE LIKE '$TriggerType'");

                if (count($emailTriggerTemp)) {
                    $users = [];
                    $emailTrigger = $emailTriggerTemp[0];
                    $usergroup = json_decode($emailTrigger->usergroup);


                    if (in_array("Patients", $usergroup)) {
                        if ($patient->email && $patient->serviceplan) {
                            array_push($users, $patient->email);
                        }
                    }
                    if (in_array("Pharmacies", $usergroup)) {
                        $pharmacyname = $patient->pharmacy;
                        $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$pharmacyname'");
                        if (count($pharmacy)) {
                            if ($pharmacy[0]->email && $pharmacy[0]->notifications) {
                                array_push($users, $pharmacy[0]->email);
                            }
                        }
                    }
                    if (in_array("Family doctors", $usergroup)) {
                        $doctorName = $patient->familyDoctor;
                        $family_doctors = DB::select("SELECT * from `family_doctors` where doctorName like '$doctorName'");
                        if (count($family_doctors)) {
                            if ($family_doctors[0]->email && $family_doctors[0]->notifications) {
                                array_push($users, $family_doctors[0]->email);
                            }
                        }
                    }
                    $content = $emailTrigger->body;
                    $placeholders = $patient;
                    $content =  str_replace("[Name]", $placeholders->firstName . ' ' . $placeholders->lastName, $content);
                    $content =  str_replace("[Birthday Date]", $this->formate_date($placeholders->birthday), $content);
                    $content =  str_replace("[Address]", $placeholders->streetNr, $content);
                    $content =  str_replace("[Phone]", $placeholders->phone1, $content);
                    $message = new Message();
                    $message->title = $emailTrigger->title;
                    $message->body = $content;
                    $message->receivers  = json_encode($users);
                    $message->delivered = 'YES';
                    $message->send_date = Carbon::now();
                    $message->save();
                    if ($placeholders->instance_id == '0') {
                        $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE '0'");
                        $email = $instanceEmail[0]->email;
                    } else {
                        $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE $placeholders->instance_id AND isOwner LIKE 1");
                        $email = $instanceEmail[0]->email;
                    }
                    foreach ($users as $user) {
                        dispatch(new SendMailJob($user, new NewArrivals($emailTrigger->title, $content, $email)));
                    }
                }
            }
        }
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
