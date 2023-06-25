<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            '2' => 'mada/',
            '3' => 'apple/',
        ];
    
        $paymentType = $paymentTypes[$request['brand_id']] ?? '';
    
        $plan = Plan::find($request['plan_id']);
        $hashedUserId = Hash::make($user->id);

        $url = url("payment/{$paymentType}{$plan->cost}/{$plan->id}/" .  $hashedUserId);

        $totalStorage = $this->packageCalculate($plan, $user->id);//after payment

        $user->update(['used_storage' => $totalStorage * 1024]);//after payment

        return $this->returnData(["url" => $url]);
    }


    public function packageCalculate($plan, $userId){

        $planStorageProperties = $plan->planProperties->filter(function ($property) {
            return strpos($property->name, 'Storage') !== false;
        });    

        $totalStorage = 0;

        foreach ($planStorageProperties as $property) {
            $totalStorage += intval($property->value);
        }

        $package = Package::where(['user_id' => $userId])->first();
        if ($package) {

            $package->update(['storage' =>  $totalStorage * 1024]);

        }else{
            $package = Package::Create([
                'storage' =>  $totalStorage * 1024,//convert from GB to MB
                'plan_id' => $plan->id,
                'user_id' => $userId
            ]);
        }
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
}
