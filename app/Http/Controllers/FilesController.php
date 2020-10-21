<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Folder;
use App\Verordnung;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\Mail\NewAttach;
class FilesController extends Controller
{
    /**
     * Display a listing of the Document.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $instance_id = $request->get('instance_id');
        if ($instance_id) {
            $documents = DB::select("SELECT t1.* ,t2.instanceName , t2.instanceLogo, t2.name , t2.email  FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id WHERE t1.instance_id LIKE $instance_id");
        } else {
            $documents = DB::select("SELECT t1.* ,t2.instanceName , t2.instanceLogo, t2.name , t2.email  FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id");
        }


        $instances = DB::select("SELECT * FROM instances ");
        $patients = DB::select("SELECT * FROM patients where instance_id like $instance_id");

        $ret = array(
            "documents" => $documents,
            "instances" => $instances,
            "patients" => $patients
        );
        return $ret;
    }
    public function indexFolder(Request $request)
    {
        $id = $request->get('instance_id');


        if ($id) {
            $documents = DB::select("SELECT t1.* ,t2.instanceName , t2.instanceLogo, t2.name , t2.email  FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id where t1.instance_id LIKE $id");
        } else {
            $documents = DB::select("SELECT t1.* ,t2.instanceName , t2.instanceLogo, t2.name , t2.email  FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id");
        }

        $services = DB::select("SELECT * from `services` order by id DESC ");

        $folders = DB::select("SELECT * from `carefolders` where instance_id like $id order by id DESC");

        $ret = array(
            "documents" => $documents,
            "services" => $services,
            "folders" => $folders
        );

        return $ret;
    }
    public function getDocument(Request $request)
    {
        $data = $request->all();
        $documentIdsTemp = $data['documents'];

        $documentIds = json_decode($documentIdsTemp);
        $documents = DB::table('documents')->whereIn('id', $documentIds)->get();

        return $documents;
    }


    /**
     * Store a newly created Document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $newData = Document::create($data);
        $res = DB::select("SELECT t1.* ,t2.instanceName , t2.instanceLogo, t2.name , t2.email  FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id where t1.id like $newData->id");
        return $res;
    }

    public function storeFolder(Request $request)
    {

        $data = $request->all();
        return Folder::create($data);
    }
    public function updateFolder(Request $request)
    {
        $data = $request->all();

        return Folder::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Ingredient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFolder(Request $request)
    {

        $res = Folder::where('id', $request->get('id'))->delete();
        return $res;
    }
    /**
     * Update the specified Document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $id = $request->get('id');
        Document::whereId($request->get('id'))->update($data);
        $res = DB::select("SELECT t1.* ,t2.instanceName , t2.instanceLogo, t2.name , t2.email  FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id where t1.id like $id");
        return $res;
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $res = Document::where('id', $request->get('id'))->delete();
        return $res;
    }

    ///Verordnung
    public function indexVerordnung(Request $request)
    {
          
        $data = $request->all();
        $instance_id = $request->get('instance_id') ;
        $verordnungs = DB::select("SELECT *  FROM verordnungs where instance_id like $instance_id"); 
        $patients = DB::select("SELECT *  FROM patients where instance_id like $instance_id");
        $instance = DB::select("SELECT instances.* , app_user.email  FROM instances LEFT JOIN app_user  ON app_user.instance_id = instances.id WHERE  app_user.isOwner LIKE 1 and instances.id like $instance_id");
        $doctors = DB::select("SELECT * from family_doctors");
        $services = DB::select("SELECT * from services");
        $ret = array(
            "verordnungs" => $verordnungs,
            "patients" => $patients,
            "instance" => $instance,
            "doctors" => $doctors,
            "services" => $services
        );
        return $ret;
    } 
   
         public function getVerordnung(Request $request)
    {         
        $id = $request->get('id');
        $verordnung= DB::select("SELECT * FROM `verordnungs` WHERE `id` = $id"); 
        $commentList = DB::select("SELECT * from `comments` where orderId like '$id'");
        $ret = array(
            "verordnung" => $verordnung,
            "commentList" => $commentList,
        );
        return $ret;
    } 
   
    public function storeVerordnung(Request $request)
    {

        $data = $request->all();
      
             return Verordnung::create($data);
    } 
    public function sendMail(Request $request)
    {
        $data = $request->all();       
       $doctor = $data['doctor'];
       $family_doctors = DB::select("SELECT * from `family_doctors` where doctorName like '$doctor'");
       $doctor = '022199968989';
       if(count($family_doctors)){
        $doctor = $family_doctors[0]->fax;
       }
       $subject = $doctor.';germeda';   
       
       
       $Verordnung['id'] = $data['id'];
       $Verordnung['send_date'] = date('Y-m-d H:i:s');
       Verordnung::whereId($request->get('id'))->update($Verordnung);
        dispatch(new SendMailJob('fax-out@placetel.de', new NewAttach($subject,$data['attachments'])));  
        return response()->json($Verordnung['send_date']);    
      
    }
    public function updateVerordnung(Request $request)
    {
        $data = $request->all();
        $id = $request->get('id');    
        return  Verordnung::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyVerordnung(Request $request)
    {
        $res = Verordnung::where('id', $request->get('id'))->delete();
        return $res;
    }
    
}
