<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Question;
use Illuminate\Notifications\Notification;
use Route;
use App\User;
use App\AppUser;
use App\AppNotification;
use App\UserNotification;
use Auth;
use App\Tutorial;
use Maatwebsite\Excel\Facades\Excel;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $instance_id = $request->get('instance_id');
        if ($instance_id) {
            $users = DB::select("SELECT * from `app_user` where instance_id like $instance_id order by id DESC ");
        } else {
            $users = DB::select("SELECT * from `app_user` where instance_id != 0 order by id DESC ");
        }

        $roles = DB::select("SELECT `role` from `roles` order by id DESC ");
        $instances = DB::select("SELECT * from `instances` order by id DESC ");

        return  $ret = array(
            "users" => $users,
            "roles" => $roles,
            "instances" => $instances
        );
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
            $data->userAvatar = url('/') . '/file_storage/' . $filename;
        }

        $Array = json_decode(json_encode($data), true);
        return AppUser::create($Array);
        
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

            $data->userAvatar = url('/') . '/file_storage/' . $filename;
        }

        $Array = json_decode(json_encode($data), true);

         AppUser::whereId($Array['id'])->update($Array);
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


        $res = AppUser::where('id', $request->get('id'))->delete();
        return $res;
    }


    public function addUser(Request $request)
    {
        $data = $request->all();
        $data['password'] = md5($data['password']);

        if ($data['instance_id'] == 0) {
            $flights = AppUser::where('instance_id', 0)->get();
            if (count($flights) > 0) {
                $ret = array(
                    "result" => "Super admin exist"
                );
            } else {
                $flights = AppUser::where('email', $data['email'])->get();
                if (count($flights) == 0) {
                                  
                    $user = AppUser::create($data);                 
                    $ret = array(
                        "result" => "success",
                        "user" => $user,                      
                    );
                } else {
                    $ret = array(
                        "result" => "exist"
                    );
                }
            }
        } else {
            $flights = AppUser::where('email', $data['email'])->get();
            if (count($flights) == 0) {
                $user = AppUser::create($data);                 
                $ret = array(
                    "result" => "success",
                    "user" => $user,                      
                );               
            } else {
                $ret = array(
                    "result" => "exist"
                );
            }
        }


        return $ret;
    }
    public function login(Request $request)
    {

        $data = $request->all();
        $md5pwd =  md5($data['password']);
        $ret = DB::select("SELECT app_user.* , roles.permissions
        FROM app_user
        LEFT JOIN roles
        ON app_user.role = roles.role WHERE `email` LIKE '$data[email]' AND (`password` LIKE '$data[password]' OR  `password` Like '$md5pwd') AND `status` LIKE 1;");

        if (count($ret) == 0) {
            $result = array(
                "result" => "failed",
                "user" => null
            );
        } else {         
            $result = array(
                "result" => "success",
                "user" => $ret[0]
            );
        }

        return $result;
    }
    public function apiSignupUser($name, $email, $password, $token)
    {
        $flights = AppUser::where('email', $email)->get();
        if (count($flights) == 0) {
            $data = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'token' => $token
            );
            $category = new AppUser($data);
            $category->save();
            $ret = array(
                "result" => "success"
            );
        } else {
            $ret = array(
                "result" => "exist"
            );
        }

        return $ret;
    }
    public function forgotPassword(Request $request)
    {

        $data = $request->all();
        $flights = AppUser::where('email', $data['email'])->get();
        if (count($flights) == 0) {
            $ret = array(
                "result" => "failed"
            );
        } else {
            $new_password = rand(1000, 9999);
            $flights = AppUser::where('email', $data['email'])
                ->update(['password' => $new_password]);
            $ret = array(
                "result" => "success"
            );

            $body = <<<EOT
        <h3>Hello </h3>
        <br>
        <p>Your password was recreated by admin.</p>
        <br>
        <p>New Password: $new_password </p>
        <br>
        <p>Thank You</p>
        <p>Club100</p>
EOT;
            $to = $data['email'];
            $subject = "[ club100 ] This is your new password. ";
            $message = $body;
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: Club100 <clubcien100@gmail.com>' . "\r\n";
            mail($to, $subject, $message, $headers);
        }

        return $ret;
    }
    public function getNotification(Request $request)
    {
        $data = $request->all();
        $categories = UserNotification::where('user_id', $data['email'])->orderBy('id', 'DESC')->get();
        return $categories;
    }
    public function apiShowCategories()
    {
        $categories = Category::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->orderBy('position', 'ASC')->withCount('children')->orderBy('title', 'ASC')->where('status', 1)->where('parent_id', null)->get();
        return $categories;
    }

    public function apiShowCategoriesPremium()
    {
        $categories = Category::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->orderBy('position', 'ASC')->withCount('children')->orderBy('title', 'ASC')->where('paid', 1)->where('status', 1)->where('parent_id', null)->get();
        return $categories;
    }

    public function apiShowCategoriesFree()
    {
        $categories = Category::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->orderBy('position', 'ASC')->withCount('children')->orderBy('title', 'ASC')->where('paid', 0)->where('status', 1)->where('parent_id', null)->get();
        return $categories;
    }

    public function apiShowChildCategories($id)
    {
        $categories = Category::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->withCount('children')->orderBy('position', 'ASC')->where('status', 1)->where('parent_id', $id)->get();
        return $categories;
    }

    public function apiShowChildCategoriesPremium($id)
    {
        $categories = Category::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->withCount('children')->orderBy('position', 'ASC')->where('paid', 1)->where('status', 1)->where('parent_id', $id)->get();
        return $categories;
    }

    public function apiShowChildCategoriesFree($id)
    {
        $categories = Category::withCount(['question' => function ($q) {
            return $q->where('status', 1);
        }])->withCount('children')->orderBy('position', 'ASC')->where('paid', 0)->where('status', 1)->where('parent_id', $id)->get();
        return $categories;
    }

    public function apiShowSingleCategory($id)
    {
        $category = Category::findorfail($id);
        return $category;
    }

    public function apiShowSingleCategoryQuestion($id)
    {
        $questions = Category::findorfail($id)->question()->where('status', 1)->get();
        return $questions;
    }

    public function apiShowQuestions()
    {
        $questions = Question::orderBy('id', 'ASC')->where('status', 1)->get();
        return $questions;
    }

    public function apiShowSingleQuestion($id)
    {
        $question = Question::findorfail($id)->get();
        return $question;
    }

    public function apiShowTutorial()
    {
        $tutorial = Tutorial::orderBy('id', 'DESC')->first();
        return $tutorial;
    }
}
