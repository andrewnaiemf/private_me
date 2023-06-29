<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use Astrotomic\Translatable\Locales;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = $this->validateRegistrationRequest($request);

        if ($validator->fails()) {
            return $this->returnValidationError(401, $validator->errors()->all());
        }

        $user = $this->createUser($request);
        $user->update(['un_used_storage' => 500 * 1048576]);

        $credentials = $request->only(['email','password','question_id','answer']);

        $token= JWTAuth::attempt($credentials);
        if (!$token) {
            return $this->unauthorized();
        }

      return  $this->respondWithToken($token,$user);
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'question_id' => 'integer|required|exists:questions,id',
            'answer' => 'required|string',
            'device_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }

        $remember = $request->boolean('remember_me', false);

        $credentials = $request->only(['email','password','question_id','answer']);

        if (! $token = JWTAuth::attempt($credentials,$remember)) {
            return $this->unauthorized();
        }


        $user = User::find(auth()->user()->id);
        $user->update([
            'lng' => $request->header('locale') ??  $user->lng
        ]);
        $this->device_token($request->device_token, $user);

        return $this->respondWithToken($token ,$user);
    }


    public function logout()
    {
        auth()->logout();
        return $this->returnSuccessMessage( trans("api.logged_out_successfully") );
    }


    protected function createUser(Request $request)
    {
        $user = User::create([
            'uuid' => strtotime("now"),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'question_id' => $request->question_id,
            'answer' => $request->answer,
            'terms' => $request->terms,
            'lng' => $request->header('locale') ?? 'en'
        ]);
        $this->device_token($request->device_token, $user);
        $user->update(['account_type' => 'user']);
        return $user;
    }



    public function refresh()
    {
        $user=User::find(auth()->user()->id);
        return $this->respondWithToken( $user->refresh(), $user);
    }


    protected function respondWithToken($token, $user)
    {
        return $this->returnData(['user' => $user , 'access_token' => $token]);
    }


    private function device_token($device_token,  $user){

        if(!isset($user->device_token)){
            $user->update(['device_token'=>json_encode($device_token)]);
        }else{
            $devices_token = $user->device_token;

            if(! in_array( $device_token , $devices_token) ){
                array_push($devices_token ,$device_token );
                $user->update(['device_token'=>json_encode( $devices_token)]);
            }
        }
    }

    protected function validateRegistrationRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'question_id' => 'integer|required|exists:questions,id',
            'answer' => 'required|string',
            'terms' => 'accepted',
            'device_token' => 'required|string'
        ]);
    }

    public function forgetPassword(Request $request){

        $validator=Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }

        $token = \Str::random(64);

        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

          \Mail::send('forgetpasstemplete', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return $this->returnSuccessMessage( trans("api.chackYourEmailToResetYourPassword") );

    }

    public function changepassword(Request $request){

        $user = User::find(auth()->user()->id);

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }
        $credentials =[ 'email' => $user->email, 'password' => $request->password];

        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->unauthorized();
        }



        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return $this->returnSuccessMessage( trans("api.Password_updated_successfully") );
    }

    public function showResetForm($token = null)
    {
        if ($token) {
            return view('resetpassword', ['token' => $token]);
        }
    }


    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = \DB::table('password_resets')
                            ->where([
                              'email' => $request->email,
                              'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        \DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect()->back();
    }

}
