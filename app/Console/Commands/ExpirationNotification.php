<?php

namespace App\Console\Commands;

use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");

        $packages = Package::whereNull('deleted_at')->where('status','PAID')->get();
        foreach ( $packages as $key =>  $package) {

            // $package->updated_at = $package->updated_at ?? $package->created_at;
            $daysDifference = $this->getDaysDifference($package->renew);
            $reciever = User::find($package->user_id);

            if ($daysDifference <= 5 && is_int($daysDifference) && $daysDifference > 0) {
                $msg = trans('api.the_package_renewal_date_is_:').$package->renew;

                if(isset($msg)){
                    $this->sendWebNotification($reciever,  $msg);
                }
            }

        $this->info('Demo:Cron Cummand Run successfully!');
        }
    }


    private function getDaysDifference($renew)
    {
        $now = Carbon::now();
        $renew = Carbon::parse($renew);

        $diff = $now->diffInDays($renew);
        if ($now > $renew) { // check if renew is before now
            $diff = -$diff; // negate the result
        }

        return  $diff;
    }

    private function sendWebNotification($reciever , $message)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey='AAAAGIXjgfY:APA91bGtS4VfEcC3r90nHGBG_0bTzszhSYgl2UwE1W3SitQjgbkPHle7fwaerx27RNeKY2szc0WAMzEvDHbRRad8EjnHsY1w8xgCqb2_XJKtpO_SSIeIDuCvz1cv50TSGDjhSlhG536K';


       $devices= ( array)(json_decode($reciever->device_token));
       $devs=[];
       foreach ($devices as $device) {
           array_push($devs, $device);
       }


        $data = [
            "registration_ids" =>array_values( $devs),
            "notification" => [
                "body" =>$message,
                "title" =>'Private me',
                "sound" => "notify.mp3",
            ],
            "data" => ["type"=>1]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        // FCM response
        return($result);
    }


}
