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
use App\DriverFriends;
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
use App\Advertisement;
use App\UserSubscription;

class AdvertisementController extends Controller
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


    // public function createDriverRoutes(Request $request)
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
    //         $request_data = [];

    //         $request_data['driver_id'] = $driver_id;
    //         $request_data['route_name'] = $route_name;
    //         $request_data['route_desc'] = isset($route_desc)?$route_desc:'';
    //         $request_data['status'] = isset($status)?true:false;
    //         $request_data['route_coordinates'] = isset($coordinates)?json_encode($coordinates):"";
    //         $driver_route_id = '';

    //         if(!empty($request_data)) {
    //             // 
    //             try {
    //                 // 
    //                 $driver_route_id = DriverRoutes::insertGetId($request_data);

    //             } catch(Exception $e) {
    //                 $response['status'] = "fail";
    //                 $response['message'] = "Error: ".$e;
    //             }
    //         }

    //         if($driver_route_id) {
    //             $response['status'] = "success";
    //             $response['message'] = "Route saved successfully!";
    //         } else {
    //             $response['status'] = "fail";
    //             $response['message'] = "fail to save!";
    //         }
            
    //         return response()->json($response);

    //     } catch(Exception $e) {
    //         $response['status'] = "fail";
    //         $response['message'] = "Error: ".$e;
    //         return response()->json($response);
    //     }

    // }


    public function advertisementList(Request $request)
    {
        // code...
        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $subscription = UserSubscription::where('user_id', $user->id)
                                            ->whereDate('end_date', '>', Carbon::now())
                                            ->first();

            // return response()->json(['dsf' => $subscription]);

            if(!empty($subscription) || $subscription == null) {
                // $advertisements = Advertisement::where('status', '1')->inRandomOrder()->get();
                $advertisements = Advertisement::where('status', '1')->inRandomOrder()->first();
                $advertisements->banner_image = url('images/banners/'.$advertisements->banner_image);
                $response['status']     = "success";
                $response['message']    = "Advertisement list!";
                $response['data']       = $advertisements;
            } else {
                $response['status']     = "fail";
                $response['message']    = "no advertisements found!";
                $response['data']       = [];
            }

            return response()->json($response);

        } catch(Exception $e) {
            $response['status']     = "fail";
            $response['message']    = "Error: ".$e;
            return response()->json($response);
        } 

    }


}
