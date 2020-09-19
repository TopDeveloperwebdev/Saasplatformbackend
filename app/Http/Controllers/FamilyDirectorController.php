<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\familyDoctor;
use Auth;
use Illuminate\Support\Facades\DB;

class FamilyDirectorController extends Controller
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
        if ($instance_id == 0) {
            $res = DB::select("SELECT * from `family_doctors` order by id DESC ");

            // orderBy('id', 'DESC')->paginate($data['pagination']);

        } else {
            //  $res = familyDoctor::where('instance_id', $data['instance_id'])->orderBy('id', 'DESC')->paginate($data['pagination']);

            $res = DB::select("SELECT * from `family_doctors` where instance_id like $instance_id  order by id DESC ");
        }

        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = familyDoctor::pluck('title', 'id');
        return view('admin.familyDoctor.create', compact('categories'));
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
        return familyDoctor::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $familyDoctor = familyDoctor::findorfail($id);
        $categories = familyDoctor::where('id', '!=', $id)->pluck('title', 'id');
        return view('admin.familyDoctor.edit', compact('familyDoctor', 'categories'));
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

        return familyDoctor::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
       
         $res=familyDoctor::where('id',$request->get('id'))->delete();   
         return $res;
        // $familyDoctor->question()->update(['status' => 0]);
        // return redirect('admin/familyDoctor')->withType('danger')->withMessage('Plan Deleted');
    }

    /**
     * Chnage status of the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function status($id, $status)
    {
        $familyDoctor = familyDoctor::findorfail($id);
        if ($status == 0) {
            $data['status'] = 1;
            $message = 'Selected familyDoctor is Active now';
        } else {
            $data['status'] = 0;
            $message = 'Selected familyDoctor is Inactive now';
        }
        $familyDoctor->update($data);
        return redirect('admin/familyDoctor')->withType('success')->withMessage($message);
    }

    public function order()
    {
        $categories = familyDoctor::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->orderBy('position', 'ASC')->get();
        return view('admin.familyDoctor.order', compact('categories'));
    }

    public function chnageOrder(Request $request)
    {
        foreach ($request['cat_id'] as $position => $cat) {
            $familyDoctor = familyDoctor::findorfail($cat);
            $data['position'] = $position + 1;
            $familyDoctor->update($data);
        }

        return redirect('admin/familyDoctor')->withType('success')->withMessage('familyDoctor Order Updated');
    }
}
