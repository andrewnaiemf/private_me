<?php

namespace App\Console\Commands;

use App\Models\Package;
use App\Models\User;
use App\Notifications\PushNotification;
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

                app()->setLocale($reciever->lng);

                $msg = trans('package.the_package_renewal_date_is_:') . $package->renew;

                $screen = 'home_screen';

                if(isset($msg)){
                    PushNotification::send($reciever, $screen, $msg, null, 1);
                }
            }elseif ($daysDifference <= 0) {//logic for expired package
                $package->delete();
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
}
