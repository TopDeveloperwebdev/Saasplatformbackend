<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\emailtemplate;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\User;
use App\Mail\NewArrivals;
use App\Trigger;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function getUsers()
    {

        return User::all();
    }

    public function getMessages()
    {

        return Message::orderBy('created_at', 'desc')->get();
    }

    public function sendMail(Request $request)
    {



        $message = new Message();
        $message->title = $request->title;
        $message->body = $request->body;
        $message->receivers  = json_encode($request->receivers);
        $message->save();

        if ($request->isNow == "now") {

            $message->delivered = 'YES';
            $message->send_date = Carbon::now();
            $message->save();

            $orderUsers = $request->get('receivers');
            $users = DB::table('app_user')->whereIn('id', $orderUsers)->get();

            //   $users = User::all();

            foreach ($users as $user) {
                dispatch(new SendMailJob($user->email, new NewArrivals($user, $message)));
            }

            return response()->json('Mail sent.', 201);
        } else {

            $message->date_string = date("Y-m-d H:i", strtotime($request->send_date));

            $message->save();

            return response()->json('Notification will be sent later.', 201);
        }
    }

    public function index(Request $request)
    {

        $instance_id = $request->get('instance_id');
        if($instance_id){
            $res = DB::select("SELECT * FROM emailtemplates where instance_id like $instance_id");
        }
        else {
            $res = DB::select("SELECT * FROM emailtemplates ");
        }
       
       

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

        return emailtemplate::create($data);
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

        return  emailtemplate::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $res = emailtemplate::where('id', $request->get('id'))->delete();
        return $res;
    }
    public function indexTrigger(Request $request)
    {
        $instance_id = $request->get('instance_id');
        $templates = DB::select("SELECT * FROM emailtemplates where instance_id like $instance_id");
   
        $triggers = DB::select("SELECT * FROM triggers where instance_id like $instance_id");;
        
        $ret = array(
            "templates" => $templates,
            "triggers" => $triggers,
        );
        return $ret;
    }

    public function storeTrigger(Request $request)
    {
        $data = $request->all();
        return Trigger::create($data);
       
    }
    public function updateTrigger(Request $request)
    {
        $data = $request->all();
        return Trigger::whereId($request->get('id'))->update($data);
    }
}
