<?php

namespace App\Http\Controllers\Api\V1;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\File; 
use Gate;
use App\Helper;
use Validator;
use App\UserMeta;
use App\UserMatch;
use App\UserMatched;
use App\LikedProfile;
use App\MailTemplate;
use App\BlockedUsers;
use App\Package;
use App\UserVerificationToken;
use Auth;
use Hash;
use App\Mail\UserMail;
use App\Mail\UserOtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Subscription;
use App\Reason;
use App\DriverRoutes;
use App\DriverAssignRoutes;
use App\Posts;
use App\Notifications;
use App\UserCard;
use App\Payments;
use App\Categories;
use App\Product;
use App\Reviews;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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
        //
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


    public function saveUserDetails(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        } 

        $validator = \Validator::make($request->all() , [
            'name' => 'required|regex:/^[\pL\s]+$/u',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()
                ->json(['status' => false, 'message' => implode("", $validator->errors()
                ->all()) ], 200);
        }

        $user_id = $user->id;

        $request_values = $request->all();
        $request_data = [];

        foreach ($request_values as $key => $value) {
            //
            if($key == 'profile_pic') {
                    //
                // if(!empty($value)) { 
                //     // $profile_image_url = Helper::createImage2($value, $user_id);
                // }
                // if(!empty($profile_image_url)) {
                //     // 
                //     // $status = Helper::update_user_meta($user_id, $key, $profile_image_url);
                //     $request_data[$key] = $profile_image_url;
                // }

                if($request->hasfile('profile_pic'))
                {
                    $file =$request->file('profile_pic'); 

                    $folderPath = "images/";
                    $name = uniqid()."_".$user_id. '_userprofile.'.$file->extension(); //time().'.'.$file->extension();
                    $file->move('images/', $name);  

                    $request_data[$key] = 'images/'.$name;
                }


            } else if($key != 'key_value'){
                $request_data[$key] = trim($value);
            }
            
        }

        if(isset($request->key_value)) {
            $key_value = $request->key_value;
            foreach ($key_value as $key => $value) {
                // code...
                Helper::update_user_meta($user_id, $key, $value);
            }
        }
        
        $user_info = User::updateOrCreate(['id' => $user_id], $request_data);

        $user_info = Helper::singleUserInfoDataChange($user_info->id, $user_info);
        $user->load('roles');
        $role = $user->roles[0]->id;

        $token = $user->createToken($user->id . '-' . now());

        if($user->name == "" && $user->name == null){
            $isRegistrationComplete = false;
        }
        else{
            $isRegistrationComplete = true;
        }


        $response['status'] = true;
        $response['message'] = 'Update successfully!';
        $response['token'] = $token->accessToken;
        $response['remember_device'] = false;
        $response['role'] = $role;
        $response['isRegistrationComplete'] = $isRegistrationComplete;
        $response['user_info'] = $user_info;

        return response()->json($response);
    }

    


    public function getUserData(Request $request)
    {
        // code...
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }
        if(!$user) {
            return response()->json(['status' => false, 'message' => 'login token error!']);
        }
        $user_id = $user->id;

        $user_info = Helper::getUserInfo($user_id);
        if(!$user_info) {
            return response()->json(['status' => false, 'message' => 'No data found!']);
        }
        
        $user_info = Helper::singleUserInfoDataChange($user_id, $user);
        
        return response()->json(['status' => true, 'message' => 'User data!', 'user_info' => $user_info]);
    }


    // function nearDriversList(Request $request) { 
    //     //
    //     if (Auth::guard('api')->check()) {
    //         $user = Auth::guard('api')->user();
    //     }

    //     if(!$user) {
    //         return response()->json(['status' => false, 'message' => 'login token error!']);
    //     }

    //     $parameters = $request->all();
    //     extract($parameters);

    //     $user_id = $user->id;
    //     $lat = isset($lat)?$lat:$user->lat;
    //     $lng = isset($lng)?$lng:$user->lng;

    //     if(empty($lat) && empty($lng)) {
    //         return response()->json(['status' => false, 'message' => 'User coordinates not found!']);
    //     }
    //     $radius = isset( $radius ) ? $radius : 10;
        
    //     $driver_list = [];

    //     $drivers = User::select('users.*', 'driver_current_route.route_coordinates', DB::raw("6371 * acos(cos(radians(" . $lat . "))
    //                         * cos(radians(users.lat)) 
    //                         * cos(radians(users.lng) - radians(" . $lng . ")) 
    //                         + sin(radians(" .$lat. ")) 
    //                         * sin(radians(users.lat))) AS distance"))
    //                         ->having("distance", "<", $radius)
    //                         ->orderBy("distance",'asc');

    //     $drivers->join('role_user', 'role_user.user_id', '=', 'users.id')->where('role_user.role_id', '=', '3'); 
    //     $drivers->leftJoin('driver_current_route', 'driver_current_route.driver_id', '=', 'users.id'); 

    //     $driver_list = $drivers->get();
        
    //     if(count($driver_list) == 0) {
    //         return response()->json(['status' => false, 'message' => 'No drivers found!', 'data' => []]);
    //     }
    //     $driver_lists = [];
    //     $coordinate = [];
    //     foreach ($driver_list as $k => $values) {
    //         // 
    //         if(json_decode($values['route_coordinates']) != null) {
    //             // 
    //             $values = Helper::singleUserInfoDataChange($values->id, $values);

    //             $values['status'] = Helper::getDriverFriendStatus($user_id,$values->id);
    //             $values['route_coordinates'] = json_decode($values['route_coordinates']);
    //             $coordinate = (array)$values['route_coordinates'];
    //             $values['start_coordinates'] = empty($coordinate) ? (object)$coordinate : reset($coordinate);
    //             $values['end_coordinates'] = empty($coordinate) ? (object)$coordinate : end($coordinate);
    //             if($values->id != $user_id){
    //                 $driver_lists[] = $values;
    //             }
    //         }
    //     }

    //     return response()->json(['status' => true, 'message' => 'Drivers list!', 'data' => $driver_lists]);
    // }


    public function verifyUserOtpVerificationMail(Request $request)
    {
        
        // if (Auth::guard('api')->check()) {
        //     $user = Auth::guard('api')->user();
        // }
        // if(!$user) {
        //     return response()->json(['status' => false, 'message' => 'login token error!']);
        // }

        $validator = \Validator::make($request->all() , [
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()
                ->json(['status' => false, 'message' => implode("", $validator->errors()
                ->all()) ], 200);
        }

        $parameters = $request->all();
        extract($parameters);

        $response = [];
        $token = UserVerificationToken::where('otp', '=', $otp)
            ->where('user_id', '=', $email)
            ->where('type', '=', 'registration_otp')
            ->first();

        if(!empty($token)) {

            $date2 = new Carbon($token->expire);
            $date1 = Carbon::now()->format('Y-m-d H:i:s'); 
            $date2 = $date2->format('Y-m-d H:i:s'); 
            
            if (strtotime($date1) > strtotime($date2)) {
                $response['status'] = false;
                $response['message'] = 'OTP is expired!';
                $token->delete();
            }
            else {
            // 

                $response['status'] = true;
                $response['message'] = 'email verfied successfully!';

                // // if($user->email == "") {
                //     $updateUser = User::find($user->id);
                //     // $updateUser->email = $email;
                //     $updateUser->isEmailVerified = 1;
                //     // $updateUser->email_verified_at = Carbon::now();
                //     // $updateUser->profile_status = ($user->profile_status > 1)? 2 : 1 ;
                //     $updateUser->device_id = isset($device_id) ? $device_id : (($user->devide_id) ? $user->devide_id : '' );
                //     $updateUser->save();
                // // }    
                // $remember_devices = [];
                // if(isset($remember_device) && $remember_device == 'true') {

                //     $remember_devices = json_decode(Helper::getUserMeta($user->id, 'remember_devices', true));
                //     if(empty($remember_devices)) {
                //         $remember_devices[] = $device_id;
                //         Helper::update_user_meta($user->id, 'remember_devices', json_encode($remember_devices));
                //     } else if (!in_array($device_id, $remember_devices)) {
                //         $remember_devices[] .= $device_id;
                //         Helper::update_user_meta($user->id, 'remember_devices', json_encode($remember_devices));
                //     }
                // }
                
                $token->delete();
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'OTP not valid!';
        }

        return response()->json($response);
    }

    public function sendForgetPasswordOtpMail(Request $request)
    {
        // code...
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
        try {
            $otp_token = UserVerificationToken::firstOrNew([
                'user_id' => $user->id, 
                'type' => 'forget_password'
            ]);
            $otp_token->otp = $otp;
            $otp_token->expire = Carbon::now()->addMinute(15);
            $otp_token->save();
        } catch(Exception $e) {
            return response()->json(['status'=>false, 'message' => 'Error in OTP!']);
        }
        $response = [];

        if($otp_token) {
            // 
            try {
                $mail_data = MailTemplate::where('mail_type', 'forget_password')->first();
                $basicinfo = [
                    '{otp}'=>$otp,
                ];
                foreach($basicinfo as $key=> $info){
                    $msg=str_replace($key,$info,$mail_data->message);
                }
                $config = ['fromemail' => $mail_data->mail_from,
                    "reply_email" => $mail_data->reply_email,
                    'otp' => $otp,
                    'subject' => $mail_data->subject, 
                    'name' => $mail_data->name,
                    'message' => $msg,
                    'otp_expire' => '15 mins'
                ];

                Mail::to($email)->send(new UserMail($config));

                $response['status'] = true;
                $response['message'] = 'Verification mail sent successfully!';

            } catch(Exception $e) {
                return response()->json(['status'=>false, 'message' => 'Error to sent OTP!']);
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'Error!';
        }

        
        return response()->json($response);
    }

    public function verifyOTP(Request $request){
        // 
        $parameters = $request->all();
        extract($parameters);
        
        if($forget_password && $otp=='') {
            return response()->json(['status' => false, 'message' => 'OTP required!']);
        }
        /*if($password != $confirm_password) {
            return response()->json(['status' => false, 'message' => 'Confirm password not matched!']);
        }*/

        $token = UserVerificationToken::where('otp', '=', $otp)
                ->where('type', '=', 'forget_password')
                ->first();

        // return $token;
        if(!empty($token)) {

            $date2 = new Carbon($token->expire);
            $date1 = Carbon::now()->format('Y-m-d H:i:s'); 
            $date2 = $date2->format('Y-m-d H:i:s'); 
            
            if (strtotime($date1) > strtotime($date2)) {
                $response['status'] = false;
                $response['message'] = 'OTP is expired!';
                $token->delete();
            }
            else {
            // 
                $response['status'] = true;
                $response['message'] = 'OTP verified!';
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'OTP not valid!';
        }

        return response()->json($response);
    }

    public function verifyForgetPasswordOTP(Request $request)
    {
        // code...
        $parameters = $request->all();
        extract($parameters);
        
        if(!isset($forget_password)) {
            $forget_password = false;
        }

        if($forget_password == "true" && $otp=='') {
            return response()->json(['status' => false, 'message' => 'OTP required!']);
        }
        // if($password != $confirm_password) {
        //     return response()->json(['status' => false, 'message' => 'Confirm password not matched!']);
        // }

        if($forget_password == "true") {
            // 
            $token = UserVerificationToken::where('otp', '=', $otp)
                ->where('type', '=', 'forget_password')
                ->first();

            if(!empty($token)) {

                $date2 = new Carbon($token->expire);
                $date1 = Carbon::now()->format('Y-m-d H:i:s'); 
                $date2 = $date2->format('Y-m-d H:i:s'); 
                
                if (strtotime($date1) > strtotime($date2)) {
                    $response['status'] = false;
                    $response['message'] = 'OTP is expired!';
                    $token->delete();
                }
                else {
                // 
                    try {
                        // User::where('id', $token->user_id)->update(['password' => Hash::make($password)]);
                        $response = array("status" => true, "message" => "OTP verified successfully!");
                        $token->delete();
                    }
                    catch (\Exception $ex) {
                        $response = array("status" => false, "message" => 'OTP is expired!');
                    }
                }
            } else {
                $response['status'] = false;
                $response['message'] = 'OTP not valid!';
            }
        } 

        // else {
        //     // 
        //     $validator = \Validator::make($request->all() , [
        //         'old_password' => 'required|min:6',
        //         'password' => 'required|min:6',
        //         'confirm_password' => 'required|same:password',
        //     ]);

        //     if ($validator->fails()) {
        //         $response = $validator->errors();
        //         return response()
        //             ->json(['status' => false, 'message' => implode("", $validator->errors()
        //             ->all()) ], 200);
        //     }

        //     // code...
        //     if (!Auth::guard('api')->check()) {
        //         return response()->json(['status' => false, 'message' => 'user not login!']);
        //     }
        //     $user = Auth::guard('api')->user();
        //     if(!$user) {
        //         return response()->json(['status' => false, 'message' => 'login token error!']);
        //     }

        //     if (Hash::check($old_password, $user->password)) { 
        //         // 
        //         try {
        //             $user->fill([ 'password' => Hash::make($password) ])->save();
        //             $response = array("status" => true, "message" => "Password changed successfully!");
        //             // $token->delete();
        //         }
        //         catch (\Exception $ex) {
        //             $response = array("status" => false, "message" => 'password not change!');
        //         }
        //     } else {
        //         $response = array("status" => false, "message" => 'Old password not matched!');
        //     }

        // }
        
        return response()->json($response);
    }


    public function changeForgetPassword(Request $request)
    {
        // code...
        $parameters = $request->all();
        extract($parameters);

        $validator = \Validator::make($request->all() , [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()
                ->json(['status' => false, 'message' => implode("", $validator->errors()
                ->all()) ], 200);
        }

        $user = User::where('email', '=', $email)->first();

        // if (Hash::check($old_password, $user->password)) { 
            // 
        try {
            $user->fill([ 'password' => Hash::make($password) ])->save();
            $response = array("status" => true, "message" => "Password changed successfully!");
            // $token->delete();
        }
        catch (\Exception $ex) {
            $response = array("status" => false, "message" => 'password not change!');
        }
        // } else {
        //     $response = array("status" => false, "message" => 'Old password not matched!');
        // }
        
        return response()->json($response);
    }


    public function reSendEmailVerificationOTP(Request $request)
    {
        // 
        $parameters = $request->all();
        extract($parameters);

        $user_email = $email; 
        if($user_email == "") {
            return response()->json(['status' => false, 'message' => 'Email id not found!']);
        }
        
        $user = User::where('email', $email)->first();
        $otp = rand(1000, 9999);
        
        $otp_token = UserVerificationToken::firstOrNew([
            'user_id' => $user->id,
            'type' => $type
        ]);

        $otp_token->otp = $otp;
        $otp_token->expire = Carbon::now()->addMinute(15);
        $otp_token->save();

        // $token = $user->createToken($user->email . '-' . now());
        $mail_data = MailTemplate::where('mail_type', $type)->first();
        $basicinfo = [
            '{otp}'=>$otp,
        ];

        foreach($basicinfo as $key=> $info){
            $msg=str_replace($key,$info,$mail_data->message);
        }

        $config = ['fromemail' => $mail_data->mail_from,
            "reply_email" => $mail_data->reply_email,
            'otp' => $otp,
            'subject' => $mail_data->subject, 
            'name' => $mail_data->name,
            'message' => $msg,
            'otp_expire' => '15 mins'
        ];

        $response = [];

        try {
            Mail::to($user_email)->send(new UserOtpVerificationMail($config));
            $response['status'] = true;
            $response['message'] = "Verification mail sent successfully!";
        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
        }
        
        return response()->json($response);
    }


    public function changeUserPassword(Request $request) 
    {
        // code...

        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $parameters = $request->all();
            extract($parameters);

            $user_id = $user->id;

            $validator = \Validator::make($request->all() , [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            if($old_password == $password) {
                return response()->json(['status' => false, 'message' => 'your current password cannot be same as previous password!']);
            }

            if (Hash::check($old_password, $user->password)) { 
                // 
                try {
                    $user->fill([ 'password' => Hash::make($password) ])->save();
                    $response = array("status" => true, "message" => "Password changed successfully!");
                    // $token->delete();
                }
                catch (\Exception $ex) {
                    $response = array("status" => false, "message" => 'password not change!');
                }
            } else {
                $response = array("status" => false, "message" => 'Old password not matched!');
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }

    public function subscriptionList(Request $request)
    {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }
            $user_id = $user->id;

            $response = [];

            try {
                // 
                $subscriptions = Subscription::all();
                $response['status'] = "success";
                $response['message'] = "Subscription List!";
                $response['data'] = $subscriptions;
            } catch(Exception $e) {
                $response['status'] = "fail";
                $response['message'] = "Error: ".$e;
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
        
    }


    public function myProfile(Request $request)
    {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $user_id = $user->id;
            $user->load('roles');

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
            
            $user = Helper::singleUserInfoDataChange($user->id, $user);
            $role = $user->roles[0]->id;
            unset($user['roles']);
            return response()->json([
                'status' => true, 
                'message' => 'Profile data!',
                'token' => $token->accessToken, 
                'remember_device' => $remember_device,
                'role' => $role,
                'user_info' => $user,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
        
    }


    // public function driverRoutes(Request $request)
    // {
    //     // code...
    //     try {

    //         if (Auth::guard('api')->check()) {
    //             $driver = Auth::guard('api')->user();
    //         }
    //         if(!$driver) {
    //             return response()->json(['status' => false, 'message' => 'login token error!']);
    //         }

    //         $parameters = $request->all();
    //         extract($parameters);

    //         if(!isset($driver_id)) {
    //             $driver_id = $driver->id;
    //         }

    //         $routes = DriverRoutes::get();

    //         foreach ($routes as $key => $route) {
    //             // code...
    //             $route->route_coordinates = json_decode($route->route_coordinates);
    //         }
    //         $response = [];

    //         try {
    //             // 
                
    //             $response['status'] = "success";
    //             $response['message'] = "Routes List!";
    //             $response['data'] = $routes;
    //         } catch(Exception $e) {
    //             $response['status'] = "fail";
    //             $response['message'] = "Error: ".$e;
    //         }
            
    //         return response()->json($response);

    //     } catch(Exception $e) {
    //         $response['status'] = "fail";
    //         $response['message'] = "Error: ".$e;
    //         return response()->json($response);
    //     }
    // }


    // public function driverAssignRoutes(Request $request) {
    //     // code...
    //     try {

    //         if (Auth::guard('api')->check()) {
    //             $driver = Auth::guard('api')->user();
    //         }
    //         if(!$driver) {
    //             return response()->json(['status' => false, 'message' => 'login token error!']);
    //         }

    //         $parameters = $request->all();
    //         extract($parameters);

    //         if(!isset($driver_id)) {
    //             $driver_id = $driver->id;
    //         }

    //         $routes = DriverAssignRoutes::where('assigned_driver_id', $driver_id)->get();
    //         $response = [];

    //         try {
    //             // 
    //             $subscriptions = Subscription::all();
    //             $response['status'] = "success";
    //             $response['message'] = "Routes List!";
    //             $response['data'] = $routes;
    //         } catch(Exception $e) {
    //             $response['status'] = "fail";
    //             $response['message'] = "Error: ".$e;
    //         }
            
    //         return response()->json($response);

    //     } catch(Exception $e) {
    //         $response['status'] = "fail";
    //         $response['message'] = "Error: ".$e;
    //         return response()->json($response);
    //     }
    // }

    // public function getRoutesByDate(Request $request)
    // {
    //     // code...
    //     try {

    //         if (Auth::guard('api')->check()) {
    //             $driver = Auth::guard('api')->user();
    //         }
    //         if(!$driver) {
    //             return response()->json(['status' => false, 'message' => 'login token error!']);
    //         }

    //         $parameters = $request->all();
    //         extract($parameters);

    //         if(!isset($driver_id)) {
    //             $driver_id = $driver->id;
    //         }

    //         $query = DriverAssignRoutes::where('assigned_driver_id', $driver_id); 
    //         $query->where('created_at', '>=', date('Y-m-d').' 00:00:00');

    //         if(isset($date)) {
    //             // 
    //             $query->where('route_date', '=', $date);
    //         }
    //         if (isset($day)) {
    //             // code...
    //             $query->where('route_day', '=', $day);
    //         }

    //         $routes = $query->get();
    //         $response = [];

    //         try {
    //             // 
    //             $subscriptions = Subscription::all();
    //             $response['status'] = "success";
    //             $response['message'] = "Routes List!";
    //             $response['data'] = $routes;
    //         } catch(Exception $e) {
    //             $response['status'] = "fail";
    //             $response['message'] = "Error: ".$e;
    //         }
            
    //         return response()->json($response);

    //     } catch(Exception $e) {
    //         $response['status'] = "fail";
    //         $response['message'] = "Error: ".$e;
    //         return response()->json($response);
    //     }
    // }

    public function privacyPolicy()
    {
        // code...
        try {

            $page = Posts::where('slug', 'privacy-policy')->where('status', 'publish')->first();

            $response['status'] = true;
            $response['message'] = "Privacy Policy";
            $response['data'] = $page;
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }

    public function termsConditions()
    {
        // code...
        try {

            $page = Posts::where('slug', 'terms-conditions')->where('status', 'publish')->first();

            $response['status'] = true;
            $response['message'] = "Terms & Conditions";
            $response['data'] = $page;
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }

    public function AboutPartwit()
    {
        // code...
        try {

            $page = Posts::where('slug', 'about-partwit')->where('status', 'publish')->first();
            $response['status'] = true;
            $response['message'] = "About Partwit";
            $response['data'] = $page;
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function updateNotification(Request $request)
    {
        // code...
        try {

            if (Auth::guard('api')->check()) {
                $driver = Auth::guard('api')->user();
            }
            if(!$driver) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $parameters = $request->all();
            extract($parameters);

            $notification = Notifications::where('id', $notification_id)->first(); 
            
            if(empty($notification)) {
                $response['status'] = "fail";
                $response['message'] = "No notifications!";
                $response['data'] = [];
            } else {
                // 
                if($status == "seen") {
                    $notification->status = 'seen';
                    $notification->save();
                    $response['status'] = "success";
                    $response['message'] = "Notifications updated!";
                }
                if($status == "delete") {
                    $notification->delete();
                    $response['status'] = "success";
                    $response['message'] = "Notifications deleted!";
                }
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }
    

    public function subscriptionPayment(Request $request) {

        // code...
        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => 'fail', 'message' => 'login token error!']);
            }

            $validator = Validator::make($request->all(), [
                'subscription_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()->json(['status' => 'success', 'message' => implode("", $validator->errors()->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $subscriptions = Subscription::where('id', $subscription_id)->first();

            require_once(base_path('vendor/stripe').'/init.php');

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $customer_id = '';
            
            if($user->customer_id == "") {
                // 
                $customer = $stripe->customers->create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'phone' => ($user->phone != '') ? $user->phone : '',
                    'description' => 'customer_'.$user->id,
                    //"source" => $src_token, 
                ]);  // -- done

                $customer_id = $customer->id;

                User::where('id', $user->id)->update([
                    'customer_id' => $customer_id,
                ]);

            } else {
                // 
                $customer_id = $user->customer_id;
            }

            // $tok = $stripe->tokens->create([
            //     'card' => [
            //         'number' => '4242424242424242',
            //         'exp_month' => 11,
            //         'exp_year' => 2022,
            //         'cvc' => '314',
            //     ],
            // ]);

            // return $tok->card->id; 

            if($new) {
                // 
                $card_token = '';

                try {
                    $cardinfo = $stripe->customers->createSource(
                        $customer_id,
                        // ['source' => $tok->id]
                        ['source' => $src_token]
                    );  //-- done

                    $card_token = $cardinfo->id;

                } 
                catch (\Stripe\Exception\InvalidRequestException $e) {
                    return response()->json(['status' => 'fail', 'message' => $e->getError()->message], 200);
                }
              
                $new_card = UserCard::insert([
                    'user_id' => $user->id, 
                    'user_customer_id' => $customer_id,
                    'card_token' => $card_token,
                ]);
              

            } else {
                // 
                // $card = UserCard::where('id', $card_id)->first();
                $card_token = $src_token;
            }

            try {
                // 
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $subscriptions->price * 100,
                    'currency' => 'usd',
                    'payment_method_types' => ['card'],
                    'customer' => $customer_id,
                    'payment_method' => $card_token, // 'card_1Jht6ZEUI2VlKHRnc5KrHBMF',
                    'transfer_group' => $subscriptions->id,
                    'confirm'=>'true',
                ]);

            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // 
                // Invalid parameters were supplied to Stripe's API
                return response()->json(['status' => 'fail', 'message' => $e->getError()->message], 200);
            }

            // return $paymentIntent; 

            if($paymentIntent->status == 'succeeded') {
                // 
                Payments::insert([
                    'user_id' => $user->id, 
                    'subscription_id' => $subscription_id,
                    'status' => $paymentIntent->status,
                    'payment_id' => $paymentIntent->id,
                    'amount' => $subscriptions->price,
                    'trans_id' => $paymentIntent->id,
                    'balance_transaction' => $paymentIntent->charges->data[0]->balance_transaction,
                    'charge_id' => $paymentIntent->charges->data[0]->id,
                ]);

                Helper::updateUserSubscriptionPlan($user->id, $subscription_id);
                // Helper::update_user_meta($user->id, 'subscription', 'premium');
                
                return response()->json(['status' => 'success', 'message' => "payment succeeded", 'data'=>$paymentIntent ], 200);

            } else {
                // 
                return response()->json(['status' => 'fail', 'message' => "payment fail", 'data' =>[] ], 200);
            }

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response); 
        }
    }


    public function addCard(Request $request)
    {
        // code...
        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => 'fail', 'message' => 'login token error!']);
            }

            $parameters = $request->all();
            extract($parameters);
            
            require_once(base_path('vendor/stripe').'/init.php');
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            if($user->customer_id == "") {
                // 
                $customer = $stripe->customers->create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'phone' => ($user->phone != '') ? $user->phone : '',
                    'description' => 'customer_'.$user->id,
                ]); 

                $customer_id = $customer->id;

                User::where('id', $user->id)->update([
                    'customer_id' => $customer_id,
                ]);
            } else {
                $customer_id = $user->customer_id;
            }
            
            $cardinfo = $stripe->customers->createSource($customer_id, ['source' => $src_token] ); 


            if(!empty($cardinfo)) {
                // 
                return response()->json([
                    'status' => 'success', 
                    'message' => "Card added successfully!", 
                    'data' => $cardinfo], 
                200);

            } else {
                // 
                return response()->json(['status' => 'fail', 'message' => "Failed to add card!"], 200);
            }

        } catch(Exception $e) {
            // 
            return response()->json(['status' => 'fail', 'message' => "Error: ".$e, 'response' => $e], 200);
        }
    }


    public function allCardsList(Request $request)
    {
        // code...
        try {
            // 
        
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => 'fail', 'message' => 'login token error!']);
            }

            $parameters = $request->all();
            extract($parameters);
            require_once(base_path('vendor/stripe').'/init.php');
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $cards = [];

            if(isset($user->customer_id)) {
                $cards = $stripe->customers->allSources(
                    $user->customer_id,
                    ['object' => 'card', 'limit' => 10]
                );
            }

            if(!empty($cards)){
                return response()->json(['status' => 'success', 'message' => "Card List!", 'data' => $cards], 200);
            } else {
                return response()->json(['status' => 'fail', 'message' => "No Card Found!", 'data' => null], 200);
            }

        } catch (Exception $e){
            return response()->json(['status' => 'fail', 'message' => "Error: ".$e, 'response' => $e], 200);
        }
    }


    public function deleteCard(Request $request)
    {
        // 
        try {
            // 

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => 'fail', 'message' => 'login token error!']);
            }
            $parameters = $request->all();
            extract($parameters);
            require_once(base_path('vendor/stripe').'/init.php');
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $sts = $stripe->customers->deleteSource(
                $user->customer_id,
                $card_id,
                []
            );

            if($sts->deleted){
                return response()->json(['status' => 'success', 'message' => "Card Deleted Successfully", 'response' => $sts], 200);
            } else {
                return response()->json(['status' => 'fail', 'message' => "Failed to delete card!", 'response' => $sts], 200);
            }

        } catch (Exception $e){
            return response()->json(['status' => 'fail', 'message' => "Error: ".$e, 'response' => $e], 200);
        }
          
    }

    public function reportReasons()
    {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }
            $reasons = Reason::all();
            return response()->json([
                'status' => true, 
                'message' => 'Report Reasons!',
                'data' => $reasons, 
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
        
    }

    public function HomePage()
    {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $categories = Categories::all();

            foreach ($categories as $ck => $cv) {
                // code...
                $products = Product::where('category_id', $cv->id)->take(10)->get();
                $product_lists = [];

                if(count($products) > 0) {
                    // 
                    foreach ($products as $pk => $pv) {
                        // code...
                        $product_lists[] = array(
                            'id' => $pv->id, 
                            'name' => $pv->name, 
                            'price' => $pv->price, 
                            'featured_image' => ($pv->featured_image != null) ? url($pv->featured_image) : url('images/product/no-image.jpeg'), 
                            'date' => Carbon::parse($pv->listed_on)->format('m/d/Y')
                        );
                    }
                }

                $data[] = array('cat_id' => $cv->id, 'title' => $cv->title, 'products' => $product_lists);    
            }

            return response()->json([
                'status' => true, 
                'message' => 'Home Page!',
                'data' => $data, 
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function SellerReviews(Request $request)
    {
        // code...

        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $validator = \Validator::make($request->all() , [
                'seller_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            // if($seller_id == $user->id) {
            //     return response()->json(['status' => false, 'message' => 'You can\'t give a review to your account']);
            // }

            $reviews = Reviews::where('seller_id', $seller_id)->get();
            return response()->json([
                'status' => true, 
                'message' => 'Seller Reviews!',
                'data' => (count($reviews) > 0)?$reviews:[],
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }
    
    public function AddSellerReviews(Request $request)
    {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $validator = \Validator::make($request->all() , [
                'seller_id' => 'required',
                'stars' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            if($seller_id == $user->id) {
                return response()->json(['status' => false, 'message' => 'You can\'t give a review to your self account!']);
            }
            $rev = Reviews::where('seller_id', $seller_id)->where('user_id', $user->id)->get();

            if(count($rev) > 0) {
                return response()->json([
                    'status' => false, 
                    'message' => 'You can\'t give a review again to the same seller!'
                ]);
            }

            $seller = User::where('id', $seller_id)->first();

            $review = Reviews::create([
                'seller_id' => $seller_id,
                'user_id' => $user->id,
                'stars' => $stars,
                'description' => isset($description)?$description:'',
                'extra_data' => json_encode([
                    'seller_name' => $seller->name,
                    'seller_id' => $seller->id,
                    'user_name' => $user->name,
                    'user_profile_pic' => ($user->profile_pic!=null)?url($user->profile_pic):'',
                    'user_id' => $user->id,
                ]),
            ]);


            return response()->json([
                'status' => true, 
                'message' => 'Review Submited Successfully!!',
                // 'data' => $review,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function SearchProduct(Request $request)
    {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $validator = \Validator::make($request->all() , [
                'search' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $products = Product::where('name', 'like', '%' .$search. '%')
            ->orWhere('short_desc', 'like', '%' .$search. '%')
            ->orWhere('short_desc', 'like', '%' .$search. '%')
            ->get();

            // $products = Product::where('category_id', $cv->id)->take(10)->get();
            $search_data = [];
            $product_lists = [];

            if(count($products) > 0) {
                // 
                foreach ($products as $pk => $pv) {
                    // code...
                    $product_lists[] = array(
                        'id' => $pv->id, 
                        'name' => $pv->name, 
                        'price' => $pv->price, 
                        'featured_image' => ($pv->featured_image != null) ? url($pv->featured_image) : url('images/product/no-image.jpeg'), 
                        'date' => Carbon::parse($pv->listed_on)->format('m/d/Y')
                    );
                }
            }

            $search_data['search'] = $search;
            $search_data['products'] = $product_lists;

            return response()->json([
                'status' => true, 
                'message' => 'Search Products!',
                'data' => $search_data,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function SendVerificationOTP(Request $request)
    {
        // 
        $parameters = $request->all();
        extract($parameters);

        if($email == "") {
            return response()->json(['status' => false, 'message' => 'Email required!']);
        }

        $user = User::where('email', $email)->first();
        if($user) {
            return response()->json(['status' => false, 'message' => 'Email Already Registred!']);
        }
        
        // $user = User::where('email', $email)->first();
        $otp = rand(1000, 9999);
        
        $otp_token = UserVerificationToken::firstOrNew([
            'user_id' => $email,
            'type' => 'registration_otp'
        ]);

        $otp_token->otp = $otp;
        $otp_token->expire = Carbon::now()->addMinute(15);
        $otp_token->save();

        // $token = $user->createToken($user->email . '-' . now());
        $mail_data = MailTemplate::where('mail_type', 'registration_otp')->first();
        $basicinfo = [
            '{otp}'=>$otp,
        ];

        foreach($basicinfo as $key=> $info){
            $msg=str_replace($key,$info,$mail_data->message);
        }

        $config = ['fromemail' => $mail_data->mail_from,
            "reply_email" => $mail_data->reply_email,
            'otp' => $otp,
            'subject' => $mail_data->subject, 
            'name' => $mail_data->name,
            'message' => $msg,
            'otp_expire' => '15 mins'
        ];

        $response = [];

        try {
            Mail::to($email)->send(new UserOtpVerificationMail($config));
            $response['status'] = true;
            $response['message'] = "Verification mail sent successfully!";
        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
        }
        
        return response()->json($response);
    }

}
