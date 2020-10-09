<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instance;
use App\AppUser;
use Auth;
use Illuminate\Support\Facades\DB;

class InstancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $instances = DB::select("SELECT instances.* ,app_user.id as userId, app_user.userAvatar, app_user.name , app_user.email , app_user.password , app_user.role , app_user.status
        FROM instances
        LEFT JOIN app_user
        ON app_user.instance_id = instances.id WHERE  `isOwner` LIKE 1;");
        $roles = DB::select("SELECT `role` from `roles` where role not like 'super administrator' order by id DESC ");

        return  $ret = array(
            "instances" => $instances,
            "roles" => $roles
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {

    //     $data = $request->all();
    //     $instance =  Instance::create($data);
    //     $data['instance_id'] = $instance->id;
    //     $data['isOwner'] = true;
    //     AppUser::create($data);
    //     $data['id'] = $instance->id;
    //     return  $data;
    // }

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
            $data->instanceLogo = url('/') . '/file_storage/' . $filename;
        }

        if ($request->hasFile('userAvatar')) {
            $userAvatar = $request->file('userAvatar');
            $destinationPath = 'file_storage/';
            $originalFile = $userAvatar->getClientOriginalName();
            $filename = strtotime(date('Y-m-d h:i:s')) . $originalFile;
            $userAvatar->move($destinationPath, $filename);
            $data->userAvatar = url('/') . '/file_storage/' . $filename;
        }

        $instanceData = json_decode(json_encode($data), true);
        $instance =  Instance::create($instanceData);
        $instanceData['instance_id'] = $instance->id;
        $instanceData['isOwner'] = true;
        AppUser::create($instanceData);
        $instanceData['id'] = $instance->id;
        return  $instanceData;
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
        $instanceData = json_decode($request->get('data'));
        //file save

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = 'file_storage/';
            $originalFile = $file->getClientOriginalName();
            $filename = strtotime(date('Y-m-d h:i:s')) . $originalFile;
            $file->move($destinationPath, $filename);

            $instanceData->instanceLogo = url('/') . '/file_storage/' . $filename;
        }
        if ($request->hasFile('userAvatar')) {
            $userAvatar = $request->file('userAvatar');
            $destinationPath = 'file_storage/';
            $originalFile = $userAvatar->getClientOriginalName();
            $filename = strtotime(date('Y-m-d h:i:s')) . $originalFile;
            $userAvatar->move($destinationPath, $filename);

            $instanceData->userAvatar = url('/') . '/file_storage/' . $filename;
        }
        $data = json_decode(json_encode($instanceData), true);
     
        $instanceModel['id'] = $data['id'];
        $instanceModel['instanceLogo'] = $data['instanceLogo'];
        $instanceModel['instanceName'] = $data['instanceName'];

        Instance::whereId($instanceModel['id'])->update($instanceModel);
        $temp = $data;
        unset($data['instanceName']);
        unset($data['instanceLogo']);
        unset($data['id']);
        unset($data['userId']);
        
        AppUser::whereId($temp['userId'])->update($data);

        return $temp;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $res = Instance::where('id', $request->get('id'))->delete();
        return $res;
    }
}
