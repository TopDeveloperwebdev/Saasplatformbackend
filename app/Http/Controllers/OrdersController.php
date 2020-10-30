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

        $medications = DB::select("SELECT medicationName from `medications` order by medicationName ASC ");



        if ($instance_id == 0) {
            $patients = DB::select("SELECT * from `patients` order by id DESC ");
            $orders = DB::select("SELECT * FROM orders  order by orders.created_at DESC");
        } else {
            //  $res = Patient::where('instance_id', $data['instance_id'])->orderBy('id', 'DESC')->paginate($data['pagination']);
            $patients = DB::select("SELECT * from `patients` where instance_id like $instance_id  order by id DESC ");

            $orders = DB::select("SELECT * FROM orders  WHERE orders.instance_id LIKE $instance_id order by orders.created_at DESC");
        }

        $ret = array(
            "patients" => $patients,
            "medications" => $medications,
            "orders" => $orders
        );
        return $ret;
    }
     public function getOrdersByUserId(Request $request)
    {
        $user_id = $request->get('user_id');
        $instance_id =$request->get('instance_id');


        if ($instance_id == 0) { 
            $patients = DB::select("SELECT * FROM patients ");
        } else {
            $patients = DB::select("SELECT * FROM patients  WHERE instance_id like $instance_id ");
        }
      
       $patientsDetail = [];
      foreach($patients as $key => $patient){     
        $orders = DB::select("SELECT * FROM orders where patient like $patient->id ");
        
        $doctorTemp = DB::select("SELECT * from `family_doctors` where doctorName like '$patient->familyDoctor'");
        $doctor= [];
        if(count($doctorTemp))$doctor =$doctorTemp[0];
 
        $pharmacyTemp = DB::select("SELECT * from `pharmacies` where pharmacyName like '$patient->pharmacy'");
        $pharmacy = [];
        if(count($pharmacyTemp))$pharmacy =$pharmacyTemp[0];
        $commentList = DB::select("SELECT * from `comments` where patient_id like $patient->id");
        $orderDetails = [];
        foreach($orders as $key => $order){     
            $orderDetail['orderId'] = $order->orderId;
            $orderDetail['id'] = $order->id;
            $orderDetail['orderNote'] = $order->note; 
            $orderDetail['date'] = $order->created_at;  
            $orderDetail['done'] = $order->done;
          $userTemp = DB::select("SELECT name , id , userAvatar from `app_user` where id like '$order->user_id'");
          $orderDetail['user'] = [];
          if(count($userTemp))$orderDetail['user'] =$userTemp[0];
   
          $userTemp =  DB::select("SELECT * from `instances` where id like '$order->instance_id'");
          $orderDetail['instance'] = [];
          if(count($userTemp)) $orderDetail['instance']=$userTemp[0];
            $orderMedications = json_decode($order->orderMedications);
            $orderDetail['Medications'] = DB::table('medications')->whereIn('medicationName', $orderMedications)->get();
          
            array_push($orderDetails, $orderDetail);
          }
        
          $object = (object) [
            'orderDetails' => $orderDetails,
             'doctor' => $doctor,
             'pharmacy' => $pharmacy,
            'id' => $patient->id,
            "patient" => $patient,
            "commentList" => $commentList
            ];
        array_push($patientsDetail, $object);
      }
      return $patientsDetail;
    
      
    } 
    public function getDetail(Request $request)
    {
        $orderId = $request->get('orderId');
        $orderTemp = DB::select("SELECT *  FROM orders where orderId like '$orderId'");
        $ret = [];
        if (count($orderTemp)) {
            $order = $orderTemp[0];

            $patient = DB::select("SELECT * from `patients` where id like '$order->patient'");
            $doctor = DB::select("SELECT * from `family_doctors` where doctorName like '$order->doctor'");
            $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$order->pharmacy'");
            $user = DB::select("SELECT name , id , userAvatar from `app_user` where id like '$order->user_id'");

            $lastOrderTemp = DB::select("SELECT * FROM orders where instance_id like $order->instance_id ORDER BY created_at DESC  LIMIT 2");
            $lastUser = [];
            $lastOrder = '';
            if (count($lastOrderTemp) > 1) {
                $lastOrder = $lastOrderTemp[1];
                $lastUser = DB::select("SELECT name ,id, userAvatar from `app_user` where id like '$lastOrder->user_id'");
            }



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
        $TriggerType = 'Benutzer erzeugt eine Bestellung';
        $data['orderId'] = $this->generateRandomString(10);
        $instance_id = $request->get('instance_id');

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
                if (in_array("Care managers", $usergroup)) {   
                    $caremanager = $patient[0]->caremanager;        
                    $caremanagers = DB::select("SELECT * from `caremanagers` where id like $caremanager");
                    if (count($caremanagers)) {
                        if ($caremanagers[0]->email && $caremanagers[0]->notifications) {
                            array_push($users, $caremanagers[0]->email);
                        }
                    }
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
          
            $instance_users = [];
            if (in_array("Related Users", $usergroup) && count($patient)) {
                $usergroup =  json_decode($patient[0]->userGroup);  
                if(count($usergroup)){
                    if($usergroup[0] == 'all'){
                        $instance_users = DB::select("SELECT email from `app_user` where instance_id not like 0");                        
                    }
                    else {
                        $instance_users = DB::table('app_user')->whereIn('name', $usergroup)->get();
                    }
                }             
            }
            if(count($instance_users)){
               foreach ($instance_users as $instance_user) {
                array_push($users, $instance_user->email);
               }
            }
        
            $content = $emailTrigger->body;

            $href = 'https://base.care/order-detail/' . $ret->orderId;
            $public_link = "<a href=" . $href . ">" . $ret->orderId . "</a>";
            $email = 'mail@base.care';
            $name = "base.care";

            if (count($patient)) {
                $placeholders = $patient[0];
                $content =  str_replace("[patient firstname]", $placeholders->firstName, $content);
                $content =  str_replace("[patient lastname]", $placeholders->lastName, $content);
                $content =  str_replace("[patient birthday]", $this->formate_date($placeholders->birthday), $content);
                $content =  str_replace("[patient insurance]", $placeholders->insurance, $content);
                $content =  str_replace("[patient address]", $placeholders->streetNr, $content);
                $content =  str_replace("[patient phone]", $placeholders->phone1, $content);
                $content =  str_replace("[patient phone]", $placeholders->phone1, $content);
                $content =  str_replace("[oder_id]", $ret->orderId, $content);
                $content =  str_replace("[order_duedate]", $this->formate_date($ret->date), $content);
                $content =  str_replace("[order_public_link]", $public_link, $content);


                if ($placeholders->instance_id == '0') {
                    $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE '0'");
                    $email = $instanceEmail[0]->email;
                    $name = "base.care";
                } else {
                    $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE $placeholders->instance_id AND isOwner LIKE 1");
                    $instanceName = DB::select("SELECT instanceName FROM instances WHERE id LIKE $placeholders->instance_id ");
                    if (count($instanceEmail)) $email = $instanceEmail[0]->email;
                    if (count($instanceName)) $name = $instanceName[0]->instanceName;
                }
            }
            $title =  $emailTrigger->title;
            $title =  str_replace("[order_id]", $ret->orderId,  $title);
            $this->sendMail($title, $content, $users, $email, $name);
        }


        return $ret;
    }
    public function formate_date($dateString)
    {
        $date = '';
        $dateStr = '';
        if ($dateString) {
            $date = explode('-', $dateString);
            $dateStr = $date[2] . '.' . $date[1] . '.' . $date[0];
        }

        return $dateStr;
    }
    public function sendMail($title, $body, $users, $instanceEmail , $name)
    {
        $message = new Message();
        $message->title = $title;
        $message->body = $body;
        $message->receivers  = json_encode($users);
        $message->delivered = 'YES';
        $message->send_date = Carbon::now();
        $message->save();

        foreach ($users as $user) {
            dispatch(new SendMailJob($user, new NewArrivals($title, $body, $instanceEmail , $name)));
        }

        return response()->json('Mail sent.', 201);
    }
    public function notifyBirthday()
    {
        $now = date("m-d", strtotime(Carbon::now()->addHour()));
        logger($now);    
        $patients = DB::select("SELECT * FROM patients WHERE birthday LIKE '%$now%'");
        if (count($patients)) {
            $TriggerType = 'Jedes Jahr an Geburtstagen';


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
                    if (in_array("Care managers", $usergroup)) {       
                        $caremanager = $patient->caremanager;        
                        $caremanagers = DB::select("SELECT * from `caremanagers` where id like $caremanager");
                        if (count($caremanagers)) {
                            if ($caremanagers[0]->email && $caremanagers[0]->notifications) {
                                array_push($users, $caremanagers[0]->email);
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
                    $email = 'mail@base.care';
                    $name = "base.care";
                    if ($placeholders->instance_id == '0') {
                        $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE '0'");
                        $email = $instanceEmail[0]->email;
                        $name = "base.care";
                    } else {
                        $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE $placeholders->instance_id AND isOwner LIKE 1");
                        $instanceName = DB::select("SELECT instanceName FROM instances WHERE id LIKE $placeholders->instance_id ");
                        if (count($instanceEmail)) $email = $instanceEmail[0]->email;
                        if (count($instanceName)) $name = $instanceName[0]->instanceName;
                    }                 
                    foreach ($users as $user) {
                        dispatch(new SendMailJob($user, new NewArrivals($emailTrigger->title, $content, $email, $name)));
                    }
                }
            }
        }
    }
    public function submit(Request $request)
    {
        $data = $request->all();
        $TriggerType = 'Kommentar für Bestellung';      
    
        $comment = $request->get('comment');
        $orderId = $request->get('orderId');
        $orderTemp = DB::select("SELECT * FROM `orders` WHERE `orderId` LIKE '$orderId'" );
        $instance_id = $orderTemp[0]->instance_id;
        $patientId = $orderTemp[0]->patient;
        $patientTemp = DB::select("SELECT * from `patients` where id like '$patientId'");
        if(count($patientTemp)){
            $patient = $patientTemp[0];
            $emailTriggerTemp = DB::select("SELECT * FROM `triggers` AS t1 LEFT JOIN emailtemplates AS t2 ON t1.template LIKE t2.title WHERE t1.instance_id LIKE '$instance_id' AND t1.TYPE LIKE '$TriggerType'");
    
            if (count($emailTriggerTemp)) {
                $users = [];
                $emailTrigger = $emailTriggerTemp[0];
                $content = $emailTrigger->body;        
                $email = 'mail@base.care';
                $name = "base.care";
                $usergroup = json_decode($emailTrigger->usergroup);         
                $family_doctorInfo = '';
                $pharmacyInfo = '';
                $caremanagerInfo = '';
                if ($patient) {
                    if($patient->email && $patient->serviceplan && in_array("Patients", $usergroup))  {
                        array_push($users, $patient->email);
                    }
                    
                    $caremanager = $patient->caremanager;        
                    $caremanagers = DB::select("SELECT * from `caremanagers` where id like $caremanager");
                    if (in_array("Care managers", $usergroup) && count($caremanagers))  {                          
                        $caremanagerInfo =  "<div style='margin-bottom : 30px'><p>" . $caremanagers[0]->firstName . "</p><p>" . $caremanagers[0]->lastName . "</p><p>Tel.: " . $caremanagers[0]->phone . "</p><p>Fax: " . $caremanagers[0]->fax . "</p></div>";
                       
                        if ($caremanagers[0]->email && $caremanagers[0]->notifications) {
                            array_push($users, $caremanagers[0]->email);
                        }
                    }
                    $pharmacyname = $patient->pharmacy;
                    $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$pharmacyname'");
                    if (in_array("Pharmacies", $usergroup) && count($pharmacy)) {
                      
                        $pharmacyInfo =  "<div style='margin-bottom : 30px'><p>" . $pharmacy[0]->pharmacyName  . "</p>";
                        $pharmacyInfo = $pharmacyInfo . "<p>" . $pharmacy[0]->streetNr . "</p>";
                        $pharmacyInfo = $pharmacyInfo . "<p>" . $pharmacy[0]->zipcode .$pharmacy[0]->city . "</p>";                
                
                        $pharmacyInfo = $pharmacyInfo .  "<p>Tel.: " . $pharmacy[0]->phone . "</p>";
                        $pharmacyInfo = $pharmacyInfo . "<p>Fax. " . $pharmacy[0]->fax . "</p></div>";
                        if ($pharmacy[0]->email && $pharmacy[0]->notifications) {
                            array_push($users, $pharmacy[0]->email);
                        }
                    }
                    $doctorName =  $patient->familyDoctor;
                    $family_doctors = DB::select("SELECT * from `family_doctors` where doctorName like '$doctorName'");
                    if (in_array("Family doctors", $usergroup) && count($family_doctors)) {                     
                        
                        $family_doctorInfo =  "<div style='margin-bottom : 30px'><p>" . $family_doctors[0]->doctorName  . "</p>";                       
                        $family_doctorInfo = $family_doctorInfo . "<p>" . $family_doctors[0]->streetNr . "</p>";
                        $family_doctorInfo = $family_doctorInfo .  "<p>" . $family_doctors[0]->zipcode . $family_doctors[0]->city ."</p>";   
                        $family_doctorInfo = $family_doctorInfo .  "<p>Tel.: " . $family_doctors[0]->phone . "</p>";
                        $family_doctorInfo = $family_doctorInfo .  "<p>Fax: " . $family_doctors[0]->fax . "</p></div>";
                        if ($family_doctors[0]->email && $family_doctors[0]->notifications) {
                            array_push($users, $family_doctors[0]->email);
                        }
                    }
                  
                    $instance_users = [];
                    $usergroup =  json_decode($patient->userGroup);  
                    if (in_array("Related Users", $usergroup) && count($usergroup)) {
                        if($usergroup[0] == 'all'){
                            $instance_users = DB::select("SELECT email from `app_user` where instance_id not like 0");                        
                        }
                        else {
                            $instance_users = DB::table('app_user')->whereIn('name', $usergroup)->get();
                        }     
                    }
                    if(count($instance_users)){
                       foreach ($instance_users as $instance_user) {
                        array_push($users, $instance_user->email);
                       }
                    }
                    $href = 'https://base.care/order-detail/' . $orderId;
                    $public_link = "<a href=" . $href . ">" . $orderId . "</a>";
                    $placeholders = $patient;  
                    $content =  str_replace("[comment]", $comment, $content);
                    $content =  str_replace("[patient]", $placeholders->firstName.' '.$placeholders->lastName, $content);
                    $content =  str_replace("[address]", $placeholders->streetNr .' '.$placeholders->zipCode.' '.$placeholders->city, $content);
                    $content =  str_replace("[phone]", $placeholders->phone1, $content);  
                    $content =  str_replace("[birthday]", $this->formate_date($placeholders->birthday), $content);
                    $content =  str_replace("[insurance]", $placeholders->insurance, $content);
                    $content =  str_replace("[insuranceNr]", $placeholders->insuranceNr, $content); 
                    $content =  str_replace("[family doctor]", $family_doctorInfo, $content); 
                    $content =  str_replace("[pharmacy]", $pharmacyInfo, $content); 
                    $content =  str_replace("[care manager]", $caremanagerInfo, $content); 
                    $content =  str_replace("[oder_id]", $orderId, $content); 
                    $content =  str_replace("[order_public_link]", $public_link, $content); 
                    if ($placeholders->instance_id == '0') {
                        $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE '0'");
                        $email = $instanceEmail[0]->email;
                        $name = "base.care";
                    } else {
                        $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE $placeholders->instance_id AND isOwner LIKE 1");
                        $instanceName = DB::select("SELECT instanceName FROM instances WHERE id LIKE $placeholders->instance_id ");
                        if (count($instanceEmail)) $email = $instanceEmail[0]->email;
                        if (count($instanceName)) $name = $instanceName[0]->instanceName;
                    }
                }   
               
                $title =  $emailTrigger->title;   
                $title =  str_replace("[oder_id]", $orderId, $title); 
               // $this->sendMail($title, $content, $users, $email, $name);
        
            }
        }  
        return Comment::create($data);
    }
    public function addComment(Request $request)
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
