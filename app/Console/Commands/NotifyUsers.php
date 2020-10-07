<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Message;
use Carbon\Carbon;
use App\Jobs\SendMailJob;
use App\User;
use App\Mail\NewArrivals;
use Illuminate\Support\Facades\DB;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //One hour is added to compensate for PHP being one hour faster 
        $now = date("m-d", strtotime(Carbon::now()->addHour()));
        logger($now);      
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
                        array_push($users, $patient->email);
                    }
                    if (in_array("Pharmacies", $usergroup)) {
                        $pharmacyname = $patient->pharmacy;
                        $pharmacy = DB::select("SELECT * from `pharmacies` where pharmacyName like '$pharmacyname'");
                        array_push($users, $pharmacy[0]->email);
                    }
                    if (in_array("Family doctors", $usergroup)) {
                        $doctorName = $patient->familyDoctor;
                        $family_doctors = DB::select("SELECT * from `family_doctors` where doctorName like '$doctorName'");
                        array_push($users, $family_doctors[0]->email);
                    }
                    $content = $emailTrigger->body;
                    $placeholders = $patient;
                    $content =  str_replace("[Name]", $placeholders->firstName . ' ' . $placeholders->lastName, $content);
                    $content =  str_replace("[Birthday Date]", $placeholders->birthday, $content);
                    $content =  str_replace("[Address]", $placeholders->streetNr, $content);
                    $content =  str_replace("[Phone]", $placeholders->phone1, $content);
                    $message = new Message();
                    $message->title = $emailTrigger->title;
                    $message->body = $content;
                    $message->receivers  = json_encode($users);
                    $message->delivered = 'YES';
                    $message->send_date = Carbon::now();
                    $message->save();
                    $instanceEmail = DB::select("SELECT email FROM app_user WHERE instance_id LIKE $patient->instance_id AND isOwner LIKE 1");
                    $instnaceName = DB::select("SELECT instanceName FROM instances WHERE instance_id LIKE $patient->instance_id ");
                    foreach ($users as $user) {
                        dispatch(new SendMailJob($user, new NewArrivals($emailTrigger->title, $content ,$instanceEmail[0]->email , $instnaceName[0]->instnaceName)));
                    }
                }
            }
        }
    }
}
