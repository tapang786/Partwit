<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\SocialAccount;
use App\UserSubscription;
use DB;
use App\Helper;
use Carbon\Carbon;
use Hash;
use App\Mail\UserOtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use App\UserVerificationToken;
use App\Reviews;

use App\Mail\UserMail;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $validator = \Validator::make($request->all() , [
            'email' => 'required|email|unique:users,email', 
            'name' => 'required|regex:/^[\pL\s]+$/u', 
            'password' => 'required|confirmed|string|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()
                ->json(['status' => false, 'message' => implode("", $validator->errors()
                ->all()) ], 200);
        }
        $parameters = $request->all();
        extract($parameters);

        $username = str_replace('.','', strstr($email, '@', true));

        $user = User::create([
            'email' => $email, 
            'name' => isset($name) ? $name : '',
            'username' => $username, 
            'password' => bcrypt($password),
        ]);
        $role = isset($role) ? $role : 2; 
        $user->roles()->attach($role); // Simple user role

        // $otp = rand(1000, 9999);

        // $otp_token = UserVerificationToken::firstOrNew([
        //     'user_id' => $user->id,
        //     'type' => 'registration_otp'
        // ]);
        // $otp_token->otp = $otp;
        // $otp_token->expire = Carbon::now()->addMinute(15);
        // $otp_token->save();

        $token = $user->createToken($user->id . '-' . now());
        // // $mail_data = MailTemplate::where('mail_type', 'register')->first();
        // $message = str_replace('{otp}',$otp, "OTP: $otp");
        // // $config = ['fromemail' => $mail_data->mail_from,
        // //     "reply_email" => $mail_data->reply_email,
        // //     'otp' => $otp,
        // //     'subject' => $mail_data->subject, 
        // //     'name' => $mail_data->name,
        // //     'otp_expire' => '15 mins',
        // //     'message'=>$message,
        // // ];

        // $config = ['fromemail' => env("ADMIN_EMAIL", "admin@admin.com"),
        //     "reply_email" => env("ADMIN_EMAIL", "admin@admin.com"),
        //     'otp' => $otp,
        //     'subject' => 'Verification mail', 
        //     'name' => 'Test',
        //     'otp_expire' => '15 mins',
        //     'message'=>$message,
        // ];

        // Mail::to($user->email)->send(new UserOtpVerificationMail($config));
        // // $user = Helper::singleUserInfoDataChange($user->id, $user);

        // $user = User::where('id','=',$user->id)->first();
        $profile_pic = '';

        if($request->hasfile('profile_pic'))
        {
            $file =$request->file('profile_pic'); 

            $folderPath = "images/";
            $name = uniqid()."_".$user->id. '_userprofile.'.$file->extension(); //time().'.'.$file->extension();
            $file->move('images/', $name);  

            $profile_pic = url('images/'.$name);
        }

        $user_info = User::updateOrCreate(['id' => $user->id], [
            'isRegistrationComplete' => true, 
            'profile_pic' => $profile_pic
        ]);

        $user_info->load('roles');
        $role = $user_info->roles[0]->id;
        unset($user_info['roles']);
        $user_info['plan'] = 'Free';
        $user_info['rating'] = 0;

        return response()->json([
            'status' => true, 
            'message' => 'Registeration successfully!',
            'isRegistrationComplete' => $user_info->isRegistrationComplete,
            'remember_device' => false, 
            'token' => $token->accessToken,
            'role' => $role, 
            'user_info' => $user_info,
        ]);
        
    }

    public function login(Request $request)
    {

        $validator = \Validator::make($request->all() , [
            'email' => 'required|email', 
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json([
                'status' => false, 
                'message' => implode("", $validator->errors()->all()) 
            ], 200);
        }
        $parameters = $request->all();
        extract($parameters);

        $user = User::where('email', $email)->first();
        if(!$user || empty($user)) {
            return response()->json(['status'=> false, 'message' => 'Email id not Registered!']);
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            //
            return response()->json([
                'status' => false, 
                'message' => 'User credentials not match', 
            ], 422);

        } else {
            // 
            $user = Auth::user();
            $user_id = $user->id;
            $user->load('roles');

            if(($user->roles[0]->id != $role)) {
                //
                return response()->json([
                    'status' => false, 
                    'message' => 'Role not match!', 
                ], 422);
            }
            unset($user['roles']);
            
            $token = $user->createToken($user->id . '-' . now());

            $remember_device = false;
            $remember_devices = json_decode(Helper::getUserMeta($user->id, 'remember_devices', true));
            if(empty($remember_devices)) {
                $remember_device = false;
            } else {
                if (in_array($device_id, $remember_devices)) {
                    $remember_device = true;
                }
            }
            
            $user->load('roles');
            $user = Helper::singleUserInfoDataChange($user->id, $user);
            $role = $user->roles[0]->id;
            unset($user['roles']);
            $UserSubscription = UserSubscription::where('user_id', $user->id)->first();
            $user['plan'] = 'Free';
            $user['rating'] = 0;
            if(isset($UserSubscription)) {
                $user['plan'] = $UserSubscription->title;
            }
            
            $rating_sum = Reviews::where('seller_id', $user_id)->sum('stars');
            $rating_total = Reviews::where('seller_id', $user_id)->count();

            if($rating_sum > 0 && $rating_total > 0) {
                $rating = $rating_sum / $rating_total;
            } else {
                $rating = 0;
            }
            $user['rating'] = $rating; 

            return response()->json([
                'status' => true, 
                'message' => 'Login successfully!',
                'token' => $token->accessToken, 
                'remember_device' => $remember_device,
                'role' => $role,
                'isRegistrationComplete' => ($user->isRegistrationComplete)?true:false,
                'user_info' => $user,
            ]);
        }
    }

    public function socialLogin(Request $request){

        $validator = \Validator::make($request->all(), [
            'social_id' => 'required',
            'social_type' => 'required'
        ]);

        if ($validator->fails()) {
            $er = [];
            $i = 0;
            foreach ($validator->errors() as $err) {
                $er[$i++] = $err[0];
                return $err;
            }

            return response()->json([
                'status' => false, 
                'message' => implode("", $validator->errors()->all()) 
            ], 200);

        }

        $parameters = $request->all();
        extract($parameters);

        $social_account = SocialAccount::where('social_id', '=', $request->social_id)
                        ->where('social_type', '=', $request->social_type)
                        ->first();

        if(empty($social_account)) {
            // 
            $getold = User::where('email', '=', $request->email)->orWhere('phone', '=', $request->phone)->first();

            $getuser = User::firstOrCreate(
                ['email' =>  isset($request->email)?$request->email:null],
                ['phone' =>  isset($request->mobile)?$request->mobile:null]
            );

            if(empty($getold)) {
                $role = isset($role) ? $role : 2; 
                $getuser->roles()->attach($role);
            }

            $user_id = $getuser->id;
            $social_account = SocialAccount::firstOrNew(['user_id' => $user_id, 'social_id' => $request->social_id, 'social_type' => $request->social_type]);
            $social_account->save();
            
        } else {
            // 
            $user_id = $social_account['user_id'];
        }

        Auth::loginUsingId($user_id);
        $user = Auth::user(); 

        if (!$user) {
            return response()->json([
                'status' => false, 
                'message' => 'Failed to login',
                'data'=>[]
            ]);
        }

        if(isset($device_id)) {
            $user = User::updateOrCreate([
                'id' => $user_id,
            ], [
                'device_id' => $request->device_id, 
            ]);
        }
        
        $token = $user->createToken($user->email . '-' . now());

        $user->load('roles');
        if(isset($user->roles)) {
            $role = 2;
        } else {
            $role = $user->roles[0]->id;
        }
        
        unset($user['roles']);

        if($user->name == "" && $user->name == null){
            $user['isRegistrationComplete'] = false;
        }
        else{
            $user['isRegistrationComplete'] = true;
        }
        
        return response()->json([
            'status' => true, 
            'message' => 'Login successfully!',
            'isUserFound'=>true,
            'token' => $token->accessToken, 
            'remember_device' => true,
            'role' => $role,
            'user_info' => $user,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all() , [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()
                ->json(['status' => false, 'message' => implode("", $validator->errors()
                ->all()) ], 200);
        }
        $parameters = $request->all();
        extract($parameters);

        $user = Helper::get_user('email', $email); 
        if(!$user) {
            return response()->json(['status'=> false, 'message' => 'Email id not found!']);
        }

        $otp = rand(1000, 9999);
        
        $response = [];

        if(true) { // $otp_token
            // 
            try {
                // $mail_data = MailTemplate::where('mail_type', 'forget_password')->first();
                $basicinfo = [
                    '{otp}'=>$otp,
                ];
                $msg = "Forgot password OTP: $otp";
                foreach($basicinfo as $key=> $info){
                    $msg=str_replace($key,$info,"Forgot password OTP: $otp");
                }
                $config = ['fromemail' => env("ADMIN_EMAIL", "admin@admin.com"),
                    "reply_email" => env("ADMIN_EMAIL", "admin@admin.com"),
                    'otp' => $otp,
                    'subject' => 'Forgot password mail', 
                    'name' => 'Test',
                    'otp_expire' => '15 mins',
                    'message'=>$msg,
                ];

                Mail::to($email)->send(new UserMail($config));

                $response['status'] = true;
                $response['message'] = 'Forgot password OTP is sent!';

            } catch(Exception $e) {
                return response()->json(['status'=>false, 'message' => 'Error to sent OTP!']);
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'Error!';
        }
        
        return response()->json($response);
    }

    public function logoutApi()
    { 
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->AauthAcessToken()->delete();
            return response()->json([
                'status' => true, 
                // 'token' => '',
                'message' => 'Logout successfully!',
            ]);
            $user = Auth::user()->token();
            $user->revoke();
        } else {
            return response()->json([
                'status' => true, 
                // 'token' => '',
                'message' => 'Already Logout!',
            ]);
        }
    }

}
