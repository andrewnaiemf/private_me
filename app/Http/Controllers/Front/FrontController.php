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
            $package = Package::where(['transaction_id' => $response['payment_id']])->first();

            $user = User::find($package->user_id);
            $package->update(['status'=>'PAID']);
            $user->update(['un_used_storage' => $package->storage]);//after payment
            return $this->returnSuccessMessage(trans("api.PaymentCreatedSuccessfully"));

        }else{
            return $this->returnError(trans('api.PaymentFaild'));
        }
    }
}
