<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use Helper;
use Carbon\Carbon;
use Hash;
use App\Mail\UserOtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
// use App\MailTemplate;
use App\UserVerificationToken;

use App\Mail\UserMail;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $validator = \Validator::make($request->all() , [
            'name' => 'required',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|min:6'
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
            'password' => bcrypt($password)
        ]);
        $role = isset($role) ? $role : 2; 
        $user->roles()->attach($role); // Simple user role

        $otp = rand(100000, 999999);

        $otp_token = UserVerificationToken::firstOrNew([
            'user_id' => $user->id,
            'type' => 'registration_otp'
        ]);
        $otp_token->otp = $otp;
        $otp_token->expire = Carbon::now()->addMinute(15);
        $otp_token->save();

        $token = $user->createToken($user->id . '-' . now());
        // $mail_data = MailTemplate::where('mail_type', 'register')->first();
        $message = str_replace('{otp}',$otp, "OTP: $otp");
        // $config = ['fromemail' => $mail_data->mail_from,
        //     "reply_email" => $mail_data->reply_email,
        //     'otp' => $otp,
        //     'subject' => $mail_data->subject, 
        //     'name' => $mail_data->name,
        //     'otp_expire' => '15 mins',
        //     'message'=>$message,
        // ];

        $config = ['fromemail' => 'tapan786@gmail.com',
            "reply_email" => 'tapan786@gmail.com',
            'otp' => $otp,
            'subject' => 'Verification mail', 
            'name' => 'Test',
            'otp_expire' => '15 mins',
            'message'=>$message,
        ];

        Mail::to($user->email)->send(new UserOtpVerificationMail($config));
        $user = \Helper::singleUserInfoDataChange($user->id, $user);
        return response()->json([
            'status' => true, 
            'token' => $token->accessToken, 
            'data' => $user,
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
            $remember_devices = json_decode(\Helper::getUserMeta($user->id, 'remember_devices', true));
            if(empty($remember_devices)) {
                $remember_device = false;
            } else {
                if (in_array($device_id, $remember_devices)) {
                    $remember_device = true;
                }
            }
            
            $user->load('roles');
            $user = \Helper::singleUserInfoDataChange($user->id, $user);
            $role = $user->roles[0]->id;
            unset($user['roles']);
            return response()->json([
                'status' => true, 
                'message' => 'Login success!',
                'token' => $token->accessToken, 
                'remember_device' => $remember_device,
                'role' => $role,
                'user_info' => $user,
            ]);
        }
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

        $user = \Helper::get_user('email', $email); 
        if(!$user) {
            return response()->json(['status'=> false, 'message' => 'Email id not found!']);
        }

        $otp = rand(100000, 999999);
        // try {
        //     $otp_token = UserVerificationToken::firstOrNew([
        //         'user_id' => $user->id, 
        //         'type' => 'forget_password'
        //     ]);
        //     $otp_token->otp = $otp;
        //     $otp_token->expire = Carbon::now()->addMinute(15);
        //     $otp_token->save();
        // } catch(Exception $e) {
        //     return response()->json(['status'=>false, 'message' => 'Error in OTP!']);
        // }
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
                $config = ['fromemail' => 'tapan786@gmail.com',
                    "reply_email" => 'tapan786@gmail.com',
                    'otp' => $otp,
                    'subject' => 'Forgot password mail', 
                    'name' => 'Test',
                    'otp_expire' => '15 mins',
                    'message'=>$msg,
                ];

                Mail::to($email)->send(new UserMail($config));

                $response['status'] = true;
                $response['message'] = 'Forgot password OTP is send!';

            } catch(Exception $e) {
                return response()->json(['status'=>false, 'message' => 'Error to send OTP!']);
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
                'token' => '',
                'message' => 'Logout successfully!',
            ]);
            $user = Auth::user()->token();
            $user->revoke();
        } else {
            return response()->json([
                'status' => true, 
                'token' => '',
                'message' => 'Already Logout!',
            ]);
        }
    }

}
