<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Folder;
use Auth;
use Illuminate\Support\Facades\DB;

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
}
