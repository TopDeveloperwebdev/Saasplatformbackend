<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Auth;
use App\Trigger;
use App\emailtemplate;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\Mail\NewArrivals;
use App\Message;
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
        $patient = Patient::create($Array);
        $this->Notification($patient);
       return $patient;
    }

   public function Notification($patient){
    $TriggerType = 'Neuer Patient';      
  
    $instance_id = $patient->instance_id;
    $patientId = $patient->id;
    
    $emailTriggerTemp = DB::select("SELECT * FROM `triggers` AS t1 LEFT JOIN emailtemplates AS t2 ON t1.template LIKE t2.title WHERE t1.instance_id LIKE $instance_id AND t1.TYPE LIKE '$TriggerType'");
   
  
    if (count($emailTriggerTemp)) {
        $users = [];
        $emailTrigger = $emailTriggerTemp[0];
        $content = $emailTrigger->body;        
        $email = 'mail@base.care';
        $name = "base.care";
        $usergroup = json_decode($emailTrigger->usergroup);         
        $family_doctorInfo = '';
        $pharmacyInfo = '';
        $caremanagerInfo='';
        $title =  $emailTrigger->title;  
        if (in_array("Patients", $usergroup) && $patient &&  $title) {
            if($patient->email && $patient->serviceplan) {
                array_push($users, $patient->email);
            }
            $caremanager = $patient->caremanager;        
            $caremanagers = DB::select("SELECT * from `caremanagers` where id like $caremanager");
            if (in_array("Care managers", $usergroup) && count($caremanagers))  {  
                $caremanagerInfo = $caremanagers[0]->firstName.' '.$caremanagers[0]->lastName.' '.$caremanagers[0]->phone.' '.$caremanagers[0]->fax;  
                if ($caremanagers[0]->email && $caremanagers[0]->notifications) {
                    array_push($users, $caremanagers[0]->email);
                }
            }
            $pharmacyname = $patient->pharmacy;
            $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$pharmacyname'");
            if (in_array("Pharmacies", $usergroup) && count($pharmacy)) {
                $pharmacyInfo = $pharmacy[0]->pharmacyName.' '.$pharmacy[0]->streetNr.' '.$pharmacy[0]->zipcode.' '.$pharmacy[0]->city.' '.$pharmacy[0]->phone.' '.$pharmacy[0]->fax; 
                if ($pharmacy[0]->email && $pharmacy[0]->notifications) {
                    array_push($users, $pharmacy[0]->email);
                }
            }
            $doctorName =  $patient->familyDoctor;
            $family_doctors = DB::select("SELECT * from `family_doctors` where doctorName like '$doctorName'");
            if (in_array("Family doctors", $usergroup) && count($family_doctors)) {   
                $family_doctorInfo = $family_doctors[0]->doctorName.' '.$family_doctors[0]->streetNr.' '.$family_doctors[0]->zipcode.' '.$family_doctors[0]->city.' '.$family_doctors[0]->phone.' '.$family_doctors[0]->fax;           
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
            $placeholders = $patient;  
            
            $content =  str_replace("[patient]", $placeholders->firstName.' '.$placeholders->lastName, $content);
            $content =  str_replace("[address]", $placeholders->streetNr .' '.$placeholders->zipCode.' '.$placeholders->city, $content);
            $content =  str_replace("[phone]", $placeholders->phone1, $content);  
            $content =  str_replace("[birthday]", $this->formate_date($placeholders->birthday), $content);
            $content =  str_replace("[insurance]", $placeholders->insurance, $content);
            $content =  str_replace("[insuranceNr]", $placeholders->insuranceNr, $content); 
            $content =  str_replace("[family doctor]", $family_doctorInfo, $content); 
            $content =  str_replace("[pharmacy]", $pharmacyInfo, $content); 
            $content =  str_replace("[care manager]", $caremanagerInfo, $content); 
        
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
             $this->sendMail($title, $content, $users, $email, $name);
        }    
    }
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
  
   public function getPatients(Request $request)
   {
   
    $instance_id = $request->get('instance_id');
    if ($instance_id == 0) {
        $patients = DB::select("SELECT * from `patients` order by id DESC ");      
    } else {       
        $patients = DB::select("SELECT * from `patients` where instance_id like $instance_id  order by id DESC ");
       
    }  

       return $patients;
   }

   public function formate_date($dateString)
    {
        $date = '';

        if ($dateString) {
            $date = explode('-', $dateString);
            $dateStr = $date[2] . '.' . $date[1] . '.' . $date[0];
        }

        return $dateStr;
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
