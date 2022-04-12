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
use App\Posts;
use App\Chat;
use App\Notifications;
use App\UserCard;
use App\Payments;
use App\Categories;
use App\Product;
use App\Reviews;
use App\Attributes;
use App\SaveItem;
use App\AttributeValue;
use App\UserSubscription;
Use Exception;
use Illuminate\Database\QueryException;




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

        if(isset($user->id)) {
            UserVerificationToken::where('user_id', $user->id)->delete();
            $otp_token = UserVerificationToken::firstOrNew([
                'user_id' => $user->id,
                'type' => $type
            ]);
        } else {
            UserVerificationToken::where('user_id', $user_email)->delete();
            $otp_token = UserVerificationToken::firstOrNew([
                'user_id' => $user_email,
                'type' => $type
            ]);
        }

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
                return response()->json(['status' => false, 'message' => 'New password can\'t be same as current password.']);
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

            $parameters = $request->all();
            extract($parameters);

            $response = [];

            try {
                // 
                // $subscriptions = Subscription::all();
                if(isset($subscription_type)) {
                    $subscriptions = Subscription::where('subscription_type', $subscription_type)->get();
                } else {
                    $subscriptions = Subscription::where('subscription_type', "!=", 'featured')->get();
                }
                
                $response['status'] = "success";
                $response['message'] = "Subscription List!";
                $response['data'] = $subscriptions;
            } catch(Exception $e) {
                $response['status'] = "fail";
                $response['message'] = "Error: ".$e;
                $response['data'] = [];
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

    public function WelcomeToPartwit()
    {
        // code...
        try {

            $page = Posts::where('slug', 'welcome-to-partwit')->where('status', 'publish')->first();
            $response['status'] = true;
            $response['message'] = "Welcome to PartWit";
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

            require_once(base_path('stripe-php').'/init.php');

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

            // return $tok->id; 

            if($isCardNew) {
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
              
                // $new_card = UserCard::insert([
                //     'user_id' => $user->id, 
                //     'user_customer_id' => $customer_id,
                //     'card_token' => $card_token,
                // ]);
              

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
                DB::table('plan_payments')->insert([
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

                $user = Helper::singleUserInfoDataChange($user->id, $user);
                
                $UserSubscription = UserSubscription::where('user_id', $user->id)->first();
                $user['plan'] = 'Free';
                $user['rating'] = 0;
                if(isset($UserSubscription)) {
                    $user['plan'] = $UserSubscription->title;
                }
                
                $rating_sum = Reviews::where('seller_id', $user->id)->sum('stars');
                $rating_total = Reviews::where('seller_id', $user->id)->count();

                if($rating_sum > 0 && $rating_total > 0) {
                    $rating = $rating_sum / $rating_total;
                } else {
                    $rating = 0;
                }
                $user['rating'] = $rating;
                
                return response()->json(['status' => 'success', 'message' => "Payment Successful", 'user_info' => $user, 'data'=>$paymentIntent ], 200);

            } else {
                // 
                return response()->json(['status' => 'fail', 'message' => "Payment fail", 'data' =>[] ], 200);
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
            
            require_once(base_path('stripe-php').'/init.php');
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $card = $stripe->tokens->create([
              'card' => [
                'number' => '4242424242424242',
                'exp_month' => 1,
                'exp_year' => 2023,
                'cvc' => '314',
              ],
            ]);

            // dd($card);

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
            
            $cardinfo = $stripe->customers->createSource($customer_id, ['source' => $src_token] ); // tok_1KJj5DItQT8ZzyO136OX3eZK
            //$cardinfo = $stripe->customers->createSource($customer_id, ['source' => $card->id] ); // tok_1KJj5DItQT8ZzyO136OX3eZK

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
            require_once(base_path('stripe-php').'/init.php');
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
            require_once(base_path('stripe-php').'/init.php');
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
                $products = Product::where('category_id', $cv->id)
                            ->whereDate('expires_on', '>', Carbon::now())
                            ->where('status', '1')
                            ->get();
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


    public function productsByCategory(Request $request) {
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
                'cat_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $products = Product::where('category_id', $cat_id)
                        ->whereDate('expires_on', '>', Carbon::now())
                        ->where('status', '1')
                        ->get();
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

                return response()->json([
                    'status' => true, 
                    'message' => 'Products list.',
                    'data' => $product_lists, 
                ]);
                // 
            } else {
                // 
                return response()->json([
                    'status' => false, 
                    'message' => 'No Products found.',
                    'data' => [], 
                ]);
            }

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
            foreach ($reviews as $review_key => $review) {
                // code...
                $seller = json_decode($review->extra_data);
                foreach ($seller as $sk => $sv) {
                    // code...
                    $reviews[$review_key][$sk] = $sv;
                }
                unset($reviews[$review_key]['deleted_at']);
                unset($reviews[$review_key]['extra_data']);
            }
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


    public function sellerSelfReviews(Request $request) {
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

            $reviews = Reviews::where('seller_id', $user->id)->get();
            foreach ($reviews as $review_key => $review) {
                // code...
                $seller = json_decode($review->extra_data);
                foreach ($seller as $sk => $sv) {
                    // code...
                    $reviews[$review_key][$sk] = $sv;
                }
                unset($reviews[$review_key]['deleted_at']);
                unset($reviews[$review_key]['extra_data']);
            }
            return response()->json([
                'status' => true, 
                'message' => (count($reviews) > 0)?'Self Reviews!':'No Reviews found!',
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

            // if(count($rev) > 0) {
            //     return response()->json([
            //         'status' => false, 
            //         'message' => 'You can\'t give a review again to the same seller!'
            //     ]);
            // }

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
                    'user_profile_pic' => ($user->profile_pic!=null)?$user->profile_pic:'',
                    'user_id' => $user->id,
                ]),
            ]);

            $meta = ['customer_id'=>$user->id,'customer_name'=>$user->name];

            $notification = $this->addNotification($seller_id, 'review', 'New Review', 'You have got a new review!', json_encode($meta), 'new');

            return response()->json([
                'status' => true, 
                'message' => 'Review submitted successfully',
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
            // ->whereDate('expires_on', '>', Carbon::now())
            // ->orWhere('short_desc', 'like', '%' .$search. '%')
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


    public function sellerListedProducts(Request $request) {
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

            $q = Product::where('seller_id', $user->id)
                        // ->whereDate('expires_on', '>', Carbon::now())
                        ->orderBy('created_at', 'DESC');

            if (isset($cat_id)) {
                // code...
                $q->where('category_id', $cat_id);
            }
            
            $products = $q->get();

            $data = [];
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
                        'date' => Carbon::parse($pv->listed_on)->format('m/d/Y'), 
                        'view_count' => $pv->view_count,
                    );
                }
            }

            $data['products'] = $product_lists;

            return response()->json([
                'status' => true, 
                'message' => 'Products!',
                'data' => $data,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function viewSellerProfile(Request $request) {
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

            $seller = User::select('id', 'name', 'profile_pic')->where('id', $seller_id)->first();
            $rating_sum = Reviews::where('seller_id', $seller_id)->sum('stars');
            $rating_total = Reviews::where('seller_id', $seller_id)->count();

            if($rating_sum > 0 && $rating_total > 0) {
                $rating = $rating_sum / $rating_total;
            } else {
                $rating = 0;
            }
            $seller['rating'] = $rating; 
            $seller['profile_pic'] = url($seller->profile_pic); 
            $products = Product::where('seller_id', $seller->id)
                            ->whereDate('expires_on', '>', Carbon::now())
                            ->where('status', '1')
                            ->orderBy('created_at', 'DESC')
                            ->get();

            $data['seller'] = $seller;
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

            $data['products'] = $product_lists;

            return response()->json([
                'status' => true, 
                'message' => 'Products!',
                'data' => $data,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function addToSaveItem(Request $request) {
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

            $validator = \Validator::make($request->all() , [
                'product_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            // SaveItem
            $saveItem = SaveItem::where('product_id', $product_id)->where('user_id', $user->id)->first();

            if(isset($saveItem)) {
                return response()->json(['status' => false, 'message' => 'Product Already in Save List!']);
            }
            
            try {

                $product = Product::where('id', $product_id)->first();

                $meta['date'] = $product->listed_on;
                $meta['featured_image'] = $product->featured_image;
                SaveItem::insert([
                    'user_id' => $user->id, 
                    'product_id' => $product_id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'meta' => json_encode($meta),
                ]);

            } catch(Exception $e) {
                // 
               return response()->json(['status' => false, 'message' => 'Error: '.$e->getMessage()]);
            }


            return response()->json([
                'status' => true, 
                'message' => 'Added to Save Items!',
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function removeSaveItem(Request $request)
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
                'save_item_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            // SaveItem
            $saveItem = SaveItem::where('id', $save_item_id)->first();

            if(!isset($saveItem)) {
                return response()->json(['status' => false, 'message' => 'Item not found!']);
            }
            
            try {
                // 
                $saveItem->delete();

            } catch(Exception $e) {
                // 
               return response()->json(['status' => false, 'message' => 'Error: '.$e->getMessage()]);
            }

            return response()->json([
                'status' => true, 
                'message' => 'Item deleted Successfully!',
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function saveItemsList(Request $request) {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            // SaveItem
            $saveItems = SaveItem::where('user_id', $user->id)->get();

            if(count($saveItems) == 0) {
                return response()->json(['status' => false, 'message' => 'No Items found!']);
            }
            
            foreach ($saveItems as $key => $item) {
                // code...
                $meta = json_decode($item->meta);
                $item['date'] = $meta->date;
                $item['featured_image'] = ($meta->featured_image)?url($meta->featured_image):'';
                unset($item['meta']);
                unset($item['created_at']);
                unset($item['updated_at']);
                unset($item['deleted_at']);
            }

            return response()->json([
                'status' => true, 
                'message' => 'Save Items List!',
                'data' => $saveItems,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }

    // Notifications List
    public function notificationsList(Request $request) {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $notifications = Notifications::where('user_id', $user->id)->orderBy('id', 'desc')->take(20)->get();

            $data = [];
            $notifications_list = [];

            if(count($notifications) > 0) {
                // 
                foreach ($notifications as $pk => $pv) {
                    // code...
                    $notifications_list[] = array(
                        'id' => $pv->id, 
                        'type' => $pv->type, 
                        'title' => $pv->title, 
                        'description' => $pv->description, 
                        'meta' => json_decode($pv->meta),
                        'status' => $pv->status,
                        'created_at' => $pv->created_at,
                        'updated_at' => $pv->updated_at,
                    );
                }
            }

            $data['notifications'] = $notifications_list;

            return response()->json([
                'status' => true, 
                'message' => 'Notifications!',
                'data' => $data,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    // Category List
    public function categoryList() {
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

            return response()->json([
                'status' => true, 
                'message' => 'Categories!',
                'data' => $categories,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }

    // Attributes List
    public function attributesList(Request $request) {
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
                'cat_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $data = [];
            $attributes = Attributes::with('values')->where('cat_id', $cat_id)->get();
            
            foreach ($attributes as $key => $attribute) {
                // code...
                // $attributes_values = AttributeValue::where('cat_id', $cat_id)->where('attr_id', $attribute->id)->get();
                // $data[$attribute->title]['id'] = $attribute->id;
                // $data[$attribute->title]['title'] = $attribute->title;
                // $data[$attribute->title]['values'] = $attributes_values;

                $data[] = $attribute;
                foreach ($attribute->values as $ky => $value) {
                    // code...
                    unset($value->type);
                    unset($value->color);
                }
                $attribute[$attribute->title] = $attribute->values;
                unset($attribute->values);
                unset($attribute->created_at);
                unset($attribute->type);
                unset($attribute->updated_at);
                unset($attribute->deleted_at);
            }

            return response()->json([
                'status' => true, 
                'message' => 'Attributes!',
                'data' => $data,
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function addChat(Request $request) {
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
                'chat_with' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $chat = Chat::firstOrNew(array('user_id' => $user->id,'chat_with' => $chat_with))->save();

            return response()->json([
                'status' => true, 
                'message' => 'Chat user save!'
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function ChatList($value='') {
        // code...
        try {
            // 
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $chat_with = Chat::where('user_id', $user->id)->pluck('chat_with')->toArray();
            $chat_to = Chat::where('chat_with', $user->id)->pluck('user_id')->toArray();

            $chats = array_unique(array_merge($chat_with,$chat_to));

            // $users = [];
            $users = User::select('name', 'profile_pic', )->whereIn('id', $chats)->get();
            
            foreach ($users as $key => $user) {
                // code...
                $user['profile_pic'] = ($user->profile_pic != null)?url($user->profile_pic):'';
            }

            return response()->json([
                'status' => true, 
                'message' => 'Chat list!', 
                'data' => $users
            ]);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }

}
