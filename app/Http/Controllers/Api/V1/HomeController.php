<?php

namespace App\Http\Controllers\Api\V1;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\File; 
use Gate;
use Helper;
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
use App\DriverRoutes;
use App\DriverAssignRoutes;
use App\Posts;
use App\Notifications;
use App\UserCard;
use App\Payments;

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

        $user_id = $user->id;

        $request_values = $request->all();
        $request_data = [];

        foreach ($request_values as $key => $value) {
            //
            if($key == 'profile_pic') {
                    //
                if(!empty($value)) { 
                    $profile_image_url = \Helper::createImage($value, $user_id);
                }
                if(!empty($profile_image_url)) {
                    // 
                    $status = \Helper::update_user_meta($user_id, $key, $profile_image_url);
                }
            } else {
                $request_data[$key] = $value;
            }
            if($key == 'city') {
                $status = \Helper::update_user_meta($user_id, $key, $value);
                // $request_data['city'] = $value;
            }
        }

        if(isset($request->key_value)) {
            $key_value = $request->key_value;
            foreach ($key_value as $key => $value) {
                // code...
                \Helper::update_user_meta($user_id, $key, $value);
            }
        }
        
        $user_info = User::updateOrCreate(['id' => $user_id], $request_data);

        $user_info = \Helper::singleUserInfoDataChange($user_info->id, $user_info);
        return response()->json(['status' => true, 'message' => 'Update successfully!', 'user_info' => $user_info]);
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

        $user_info = \Helper::getUserInfo($user_id);
        if(!$user_info) {
            return response()->json(['status' => false, 'message' => 'No data found!']);
        }
        
        $user_info = \Helper::singleUserInfoDataChange($user_id, $user);
        
        return response()->json(['status' => true, 'message' => 'User data!', 'user_info' => $user_info]);
    }


    function nearDriversList(Request $request) { 
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
        $lat = isset($lat)?$lat:$user->lat;
        $lng = isset($lng)?$lng:$user->lng;

        if(empty($lat) && empty($lng)) {
            return response()->json(['status' => false, 'message' => 'User coordinates not found!']);
        }
        $radius = isset( $radius ) ? $radius : 10;
        
        $driver_list = [];

        $drivers = User::select('users.*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                            * cos(radians(users.lat)) 
                            * cos(radians(users.lng) - radians(" . $lng . ")) 
                            + sin(radians(" .$lat. ")) 
                            * sin(radians(users.lat))) AS distance"))
                            ->having("distance", "<", $radius)
                            ->orderBy("distance",'asc');

        $drivers->join('role_user', 'role_user.user_id', '=', 'users.id')->where('role_user.role_id', '=', '3'); 

        $driver_list = $drivers->get();
        
        if(count($driver_list) == 0) {
            return response()->json(['status' => false, 'message' => 'No drivers found!', 'data' => []]);
        }
        $driver_lists = [];
        foreach ($driver_list as $k => $values) {
            // 
            $values = \Helper::singleUserInfoDataChange($values->id, $values);

            $values['status'] = \Helper::getDriverFriendStatus($user_id,$values->id);

            if($values->id != $user_id){
                $driver_lists[] = $values;
            }
        }

        return response()->json(['status' => true, 'message' => 'Drivers list!', 'data' => $driver_lists]);
    }


    public function verifyUserOtpVerificationMail(Request $request)
    {
        
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }
        if(!$user) {
            return response()->json(['status' => false, 'message' => 'login token error!']);
        }

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
            ->where('user_id', '=', $user->id)
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
                // $user = User::updateOrCreate([
                //     'id' => $user->id,
                // ], [
                //     'isEmailVerified' => 1, 
                // ]);
                
                $response['status'] = true;
                $response['message'] = 'email verfied successfully!';

                // if($user->email == "") {
                    $updateUser = User::find($user->id);
                    // $updateUser->email = $email;
                    $updateUser->isEmailVerified = 1;
                    // $updateUser->email_verified_at = Carbon::now();
                    // $updateUser->profile_status = ($user->profile_status > 1)? 2 : 1 ;
                    $updateUser->device_id = isset($device_id) ? $device_id : (($user->devide_id) ? $user->devide_id : '' );
                    $updateUser->save();
                // }    
                $remember_devices = [];
                if(isset($remember_device) && $remember_device == 'true') {

                    $remember_devices = json_decode(\Helper::getUserMeta($user->id, 'remember_devices', true));
                    if(empty($remember_devices)) {
                        $remember_devices[] = $device_id;
                        \Helper::update_user_meta($user->id, 'remember_devices', json_encode($remember_devices));
                    } else if (!in_array($device_id, $remember_devices)) {
                        $remember_devices[] .= $device_id;
                        \Helper::update_user_meta($user->id, 'remember_devices', json_encode($remember_devices));
                    }
                }
                
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

        $user = \Helper::get_user('email', $email); 
        if(!$user) {
            return response()->json(['status'=> false, 'message' => 'Email id not found!']);
        }

        $otp = rand(100000, 999999);
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
                $response['message'] = 'OTP is send!';

            } catch(Exception $e) {
                return response()->json(['status'=>false, 'message' => 'Error to send OTP!']);
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

    public function changeUserPassword(Request $request)
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
        if($password != $confirm_password) {
            return response()->json(['status' => false, 'message' => 'Confirm password not matched!']);
        }

        if($forget_password == "true") {
            // 
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
                    try {
                        User::where('id', $token->user_id)->update(['password' => Hash::make($password)]);
                        $response = array("status" => true, "message" => "Password changed successfully!");
                        $token->delete();
                    }
                    catch (\Exception $ex) {
                        $response = array("status" => false, "message" => 'password not change!');
                    }
                }
            } else {
                $response['status'] = false;
                $response['message'] = 'OTP not valid!';
            }
        } else {
            // 
            $validator = \Validator::make($request->all() , [
                'old_password' => 'required|min:6',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            // code...
            if (!Auth::guard('api')->check()) {
                return response()->json(['status' => false, 'message' => 'user not login!']);
            }
            $user = Auth::guard('api')->user();
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
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

        }
        
        return response()->json($response);
    }


    public function reSendEmailVerificationOTP(Request $request)
    {

        $parameters = $request->all();
        extract($parameters);

        $user_email = $email; 
        if($user_email == "") {
            return response()->json(['status' => false, 'message' => 'Email id not found!']);
        }

        $user = User::where('email', $email)->first();
        $otp = rand(100000, 999999);
        $otp_token = UserVerificationToken::firstOrNew([
            'user_id' => $user->id,
            'type' => $type
        ]);
        $otp_token->otp = $otp;
        $otp_token->expire = Carbon::now()->addMinute(15);
        $otp_token->save();

        // $token = $user->createToken($user->email . '-' . now());
        $mail_data = MailTemplate::where('mail_type', 'verification_mail')->first();
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
            $response['status'] = "success";
            $response['message'] = "Verification mail send successfully!";
        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
        }
        
        return response()->json($response);
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


    public function driverRoutes(Request $request)
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

            if(!isset($driver_id)) {
                $driver_id = $driver->id;
            }

            $routes = DriverRoutes::get();

            foreach ($routes as $key => $route) {
                // code...
                $route->route_coordinates = json_decode($route->route_coordinates);
            }
            $response = [];

            try {
                // 
                
                $response['status'] = "success";
                $response['message'] = "Routes List!";
                $response['data'] = $routes;
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


    public function driverAssignRoutes(Request $request)
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

            if(!isset($driver_id)) {
                $driver_id = $driver->id;
            }

            $routes = DriverAssignRoutes::where('assigned_driver_id', $driver_id)->get();
            $response = [];

            try {
                // 
                $subscriptions = Subscription::all();
                $response['status'] = "success";
                $response['message'] = "Routes List!";
                $response['data'] = $routes;
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

    public function getRoutesByDate(Request $request)
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

            if(!isset($driver_id)) {
                $driver_id = $driver->id;
            }

            $query = DriverAssignRoutes::where('assigned_driver_id', $driver_id); 
            $query->where('created_at', '>=', date('Y-m-d').' 00:00:00');

            if(isset($date)) {
                // 
                $query->where('route_date', '=', $date);
            }
            if (isset($day)) {
                // code...
                $query->where('route_day', '=', $day);
            }

            $routes = $query->get();
            $response = [];

            try {
                // 
                $subscriptions = Subscription::all();
                $response['status'] = "success";
                $response['message'] = "Routes List!";
                $response['data'] = $routes;
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

    public function privacyPolicy()
    {
        // code...
        try {

            $page = Posts::where('slug', 'privacy-policy')->first();

            $subscriptions = Subscription::all();
            $response['status'] = "success";
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

            $page = Posts::where('slug', 'terms-conditions')->first();

            $subscriptions = Subscription::all();
            $response['status'] = "success";
            $response['message'] = "Terms & Conditions";
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

            $tok = $stripe->tokens->create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 11,
                    'exp_year' => 2022,
                    'cvc' => '314',
                ],
            ]);

            // return $tok->card->id; 

            if($new) {
                // 
                $card_token = '';

                try {
                    $cardinfo = $stripe->customers->createSource(
                        $customer_id,
                        ['source' => $tok->id]
                        // ['source' => $src_token]
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

                \Helper::updateUserSubscriptionPlan($user->id, $subscription_id);
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
            $cardinfo = $stripe->customers->createSource($user->customer_id, ['source' => $src_token] ); 


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

}
