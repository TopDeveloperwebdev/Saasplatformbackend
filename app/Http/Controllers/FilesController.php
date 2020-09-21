<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
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
        $res = DB::select("SELECT id , title , created_at  from `documents` order by id DESC ");
        return $res;
    }

   public function getDocument(Request $request)
    {
        $data = $request->all();
        $documentId = $data['id'];
        
        $res = DB::select("SELECT * FROM documents AS t1 LEFT JOIN (SELECT  instances.* , app_user.name , app_user.email  FROM instances  LEFT JOIN app_user ON instances.id LIKE app_user.instance_id WHERE app_user.isOwner LIKE 1) AS t2 ON t1.instance_id = t2.id WHERE t1.id LIKE $documentId");
        
        return $res;
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
        return Document::create($data);
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

        return Document::whereId($request->get('id'))->update($data);
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
