<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Nafezly\Payments\Classes\HyperPayPayment;

class FrontController extends Controller
{
    public function payment_verify(Request $request){

        $payment = new HyperPayPayment();
        $response = $payment->verify($request);
        if($response['success']){
            $user = User::find(auth()->user()->id);

            $package = Package::where(['transaction_id' => $response['payment_id']])->first();
            $user->update(['un_used_storage' => $package->storage]);//after payment
        }
        dd($response);



        return $this->returnData(["url" => $url]);
    }
}
