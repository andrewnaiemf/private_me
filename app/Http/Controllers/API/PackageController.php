<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Directory;
use App\Models\Package;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Nafezly\Payments\Classes\HyperPayPayment;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $paymentTypes = [
            '1' => 'CREDIT',
            '2' => 'MADA',
            '3' => 'APPLE',
        ];
        $paymentType = $paymentTypes[$request['brand_id']] ;


        $plan = Plan::find($request['plan_id']);
        $amount = number_format($plan->cost, 2, '.', '');


        $payment = new HyperPayPayment();

        $response = $payment->pay(
            $amount,
            $user_id = $user->id,
            $user_first_name = $user->name,
            $user_last_name = $user->name,
            $user_email = $user->email,
            $user_phone = $user->phone ?? '0000',
            $source = $paymentType
        );

        $totalStorage = $this->packageCalculate($plan, $user->id, $response, $paymentType);
        // dd('aaa',$totalStorage);
        $htmlContent = $response['html'];

        $package = Package::where(['user_id' => $user->id])->latest()->first();


        $domain = env('APP_URL') ?? 'https://privatemesa.co/';

        $url = $domain.'payment/'.$package->transaction_id;
        return $this->returnData(['url' => $url]);

    }


    public function packageCalculate($plan, $userId, $paymentData, $paymentType){

        $planStorageProperties = $plan->planProperties->filter(function ($property) {
            return $property->translations->where('locale', 'en')->isNotEmpty()
                && (strpos($property->name, 'Storage') !== false || strpos($property->name, 'Free Storage') !== false);
        });

        $totalStorage = 0;

        foreach ($planStorageProperties as $property) {
            $totalStorage += intval($property->value);
        }

        $package = Package::where(['user_id' => $userId])->first();
        $bytes_storage =  $totalStorage * 1024  * 1024 * 1024;//convert from GB to bytes

        if (isset($package) && $package->status != 'PAID') {
            $package->update([
                'storage' =>  $bytes_storage,
                'transaction_id' => $paymentData['payment_id'],
                'content' => $paymentData['html'],
                'plan_id' => $plan->id,
                'status' => null,
            ]);

        }else{
            // Get the soft-deleted packages for the user
            $packages = Package::onlyTrashed()->where('user_id', $userId)->get();

            //Loop through the packages and force delete them
            foreach ($packages as $package) {
                $package->forceDelete();
            }

            $package = Package::Create([
                'storage' =>  $bytes_storage,
                'plan_id' => $plan->id,
                'user_id' => $userId,
                'transaction_id' => $paymentData['payment_id'],
                'content' => $paymentData['html'],
                'payment_method' => $paymentType
            ]);
        }
        $renew ='';
        if ($package->plan->type == 'Monthly') {
            $renew = Carbon::parse($package->updated_at)->addMonth();
        }else{
            $renew = Carbon::parse($package->updated_at)->addYear();
        }
        $package->update(['renew' => $renew]);


        return  $totalStorage;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cancel(){

        $user = User::find(auth()->user()->id);

        //delete all user storage.
        $path = "storage/Customer/{$user->id}/Space";
        $user->update(['un_used_storage' => 500 * 1048576]);

        if (file_exists(public_path($path))) {
            File::deleteDirectory(public_path($path));

            // Delete directories and their associated files
            $user->directories()->each(function ($directory) {
                $directory->files()->delete();
                $directory->delete();
            });

        }


        $package = Package::where(['user_id' => $user->id])->first();

        if (isset($package)) {
            $package->forceDelete();
        }

        return $this->returnSuccessMessage( trans("api.packageCanceledsuccessfully") );

    }
}
