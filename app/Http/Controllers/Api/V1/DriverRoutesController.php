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
use App\Notifications;
use App\ShareRoute;
use App\DriverCurrentRoute;

class DriverRoutesController extends Controller
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


    public function createDriverRoutes(Request $request)
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
            $request_data = [];

            $request_data['driver_id'] = $driver_id;
            $request_data['route_name'] = $route_name;
            $request_data['route_desc'] = isset($route_desc)?$route_desc:'';
            $request_data['status'] = isset($status)?true:false;
            $request_data['route_coordinates'] = isset($coordinates)?json_encode($coordinates):"";
            $driver_route_id = '';

            if(!empty($request_data)) {
                // 
                try {
                    // 
                    $driver_route_id = DriverRoutes::insertGetId($request_data);

                } catch(Exception $e) {
                    $response['status'] = "fail";
                    $response['message'] = "Error: ".$e;
                }
            }

            if($driver_route_id) {
                $response['status'] = "success";
                $response['message'] = "Route saved successfully!";
            } else {
                $response['status'] = "fail";
                $response['message'] = "fail to save!";
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }

    }


    public function singleDriverRoutes(Request $request)
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

            $driver_routes = DriverRoutes::where('driver_id', $driver_id)->orderBy('id', 'DESC')->get();

            foreach ($driver_routes as $key => $route) {
                // code...
                $route->route_coordinates = json_decode($route->route_coordinates);
            }
            if(count($driver_routes) > 0) {
                // 
                $response['status'] = "success";
                $response['message'] = "Route saved successfully!";
                $response['data'] = $driver_routes;
            } else {
                $response['status'] = "fail";
                $response['message'] = "No rouets found!";
                $response['data'] = [];
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


    public function sendDriverFriendRequest(Request $request)
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

            $friendRequest = DriverFriends::create(['send_by' => $driver->id, 'send_to' => $driver_id]);
            
            if($friendRequest) {
                // 
                $response['status'] = "success";
                $response['message'] = "Request send successfully!";
                $response['data'] = $friendRequest;
            } else {
                $response['status'] = "fail";
                $response['message'] = "Request not send!";
                $response['data'] = [];
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


    public function acceptDriverFriendRequest(Request $request)
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

            $friendRequest = DriverFriends::where('send_by', $driver_id)
                                        ->where('send_to', $driver->id)
                                        ->first();

                                     
            if($friendRequest) {
                // 

                if($friendRequest->status == 'accepted') {
                    $response['status'] = "success";
                    $response['message'] = "Already accepted!";
                    $response['data'] = $friendRequest;
                    return response()->json($response);
                } else {
                    $friendRequest->status = 'accepted';
                    $friendRequest->save();
                }  

                $response['status'] = "success";
                $response['message'] = "Request accepted successfully!";
                $response['data'] = $friendRequest;
            } else {
                $response['status'] = "fail";
                $response['message'] = "Request not send!";
                $response['data'] = [];
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }
    

    public function driversFriendsList(Request $request)
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

            $friendRequest_send = DriverFriends::where('send_by', $driver->id)
                                            ->where('status', 'accepted')
                                            ->leftJoin('users', 'driver_friends.send_to', '=', 'users.id')
                                            ->get();

            $friendRequest_recive = DriverFriends::where('send_to', $driver->id)
                                            ->where('status', 'accepted')
                                            ->leftJoin('users', 'driver_friends.send_by', '=', 'users.id')
                                            ->get();

            $friends = [];
            foreach ($friendRequest_send as $k => $friend) {
                // code...
                $friend['driver_id'] = $friend->send_to;
                $friend['profile_pic'] = \Helper::getUserMeta($friend->send_to, 'profile_pic', true); //;
                unset($friend['send_by']);
                unset($friend['send_to']);
                $friends[] = $friend;
            }
            foreach ($friendRequest_recive as $k => $friend) {
                // code...
                $friend['driver_id'] = $friend->send_by;
                $friend['profile_pic'] = \Helper::getUserMeta($friend->send_by, 'profile_pic', true); //;
                unset($friend['send_by']);
                unset($friend['send_to']);
                $friends[] = $friend;
            }

            if(!empty($friends)) {
                // 
                $response['status'] = "success";
                $response['message'] = "Friends driver list!";
                $response['data'] = $friends;
            } else {
                $response['status'] = "fail";
                $response['message'] = "Friends not found!";
                $response['data'] = [];
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


    public function driverFriendsRequestList(Request $request)
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

            $friends_requests = DriverFriends::where('send_to', $driver->id)
                                                ->where('status', 'requested')
                                                ->leftJoin('users', 'driver_friends.send_by', '=', 'users.id')
                                                ->get();

            if(!empty($friends_requests)) {
                // 

                $friends = [];
                foreach ($friends_requests as $k => $friend) {
                    // code...
                    $friend['driver_id'] = $friend->id;
                    $friend['profile_pic'] = \Helper::getUserMeta($friend->id, 'profile_pic', true); //;
                    unset($friend['send_by']);
                    unset($friend['send_to']);
                    $friends[] = $friend;
                }

                $response['status'] = "success";
                $response['message'] = "Drivers Friends Request List";
                $response['data'] = $friends;
            } else {
                $response['status'] = "fail";
                $response['message'] = "No Request found!";
                $response['data'] = [];
            }
            
            return response()->json($response);


        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


    public function cancleDrivrFriendReqest(Request $request)
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

            $friends_request = DriverFriends::where('send_to', $driver->id)
                                                ->where('status', 'requested')
                                                ->where('send_by', $driver_id)
                                                ->first();

            if(!empty($friends_request)) {
                // 

                $friends_request->status = 'rejected';
                $friends_request->save();

                $response['status'] = "success";
                $response['message'] = "Driver Friend Request is cancled!";
                $response['data'] = [];
                
            } else {
                $response['status'] = "fail";
                $response['message'] = "No Request found!";
                $response['data'] = [];
            }
            
            return response()->json($response);


        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


    public function shareRoute(Request $request)
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
            
            // return $parameters; 

            if(!isset($driver_id)) {
                return response()->json(['status' => false, 'message' => 'Driver id requrid!']);
            }
            if(!isset($route_id)) {
                return response()->json(['status' => false, 'message' => 'Route id requrid!']);
            }

            $driver_route = DriverRoutes::where('id', $route_id)->first();
            // $route->driver_id = $driver_id;
            // $route->save();

            $route = ShareRoute::where('route_id', $route_id)->first();
            if(empty($route)) {
                $share_route = ShareRoute::create([
                    "share_by"  => $driver->id, 
                    "share_to"  => $driver_id, 
                    "route_id"  => $route_id, 
                    "date"      => $date, 
                ]);

                $response['status'] = "success";
                $response['message'] = "Route Shared Successfully!";
                $response['data'] = [];

                $title  = 'Route is shared';
                $desc   = $driver->name.' shared route with you!';
                $type   = 'route_shared'; 
                
                $extra['route_id'] = $route_id;
                // $extra['driver_id'] = $driver_id;
                $shared_to_user = User::where('id', $driver_id)->first();

                $extra['shared_to_id'] = $driver_id;
                $extra['shared_to_name'] = $shared_to_user->name;
                $extra['shared_to_profile_pic'] = (\Helper::getUserMeta($driver_id, 'profile_pic', true) != '')?url(\Helper::getUserMeta($driver_id, 'profile_pic', true)):'';

                $extra['shared_by_id'] = $driver->id;
                $extra['shared_by_name'] = $driver->name;
                $extra['shared_by_profile_pic'] = (\Helper::getUserMeta($driver->id, 'profile_pic', true) != '')?url(\Helper::getUserMeta($driver->id, 'profile_pic', true)):'';
                $extra['route_name'] = $driver_route->route_name;
                $extra['shared_date'] = Carbon::now()->format('Y-m-d H:i:s'); 

                $notification = \Helper::createNotification($driver_id, $title, $desc, $type, json_encode($extra), $date);

            } else {
                // 
                $response['status'] = "fail";
                $response['message'] = "Route Already Shared!";
                $response['data'] = [];
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }



    public function driverRoutesNotifications(Request $request)
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
            $query = Notifications::where('user_id', $driver_id); 

            $query->where(function($qry){
                $qry->whereDate('date', '<', Carbon::now())
                      ->orWhere('date', '=', null);
            })
            ->orderBy('id', 'DESC');
            $notifications = $query->get(); 

            if(count($notifications) > 0) {

                foreach ($notifications as $key => $notification) {
                    // code...
                    $notification->extra = json_decode($notification->extra); 
                }

                $response['status'] = "success";
                $response['message'] = "Notifications!";
                $response['data'] = $notifications;
            } else {
                $response['status'] = "fail";
                $response['message'] = "No notifications!";
                $response['data'] = [];
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function updateRequestedRoute(Request $request)
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
            // $driver_id = 144; 

            $share_route = ShareRoute::where('route_id', $route_id)->first(); 

            if(empty($share_route)) {
                // 
                $response['status'] = "fail";
                $response['message'] = "No shared route found!";
                $response['data'] = [];

            } else {
                //
                if($action == "accepted") {
                    // 
                    $driver_route = DriverRoutes::where('id', $route_id)->first();
                    $driver_route->driver_id = $driver_id;
                    $driver_route->save();

                    $extra['route_name'] = $driver_route->route_name;

                    $share_route->status = "accepted"; //rejected
                    $share_route->save();

                    $response['status'] = "success";
                    $response['message'] = "Route accepted!";
                    $response['data'] = [];
                }

                if($action == "rejected") {
                    // 
                    $share_route->status = "rejected"; //rejected
                    $share_route->save();

                    $response['status'] = "success";
                    $response['message'] = "Route rejected!";
                    $response['data'] = [];
                }

                $title  = 'Route is '.$action;
                $desc   = $driver->name.' '. $action. ' your route!';
                $type   = 'route_shared'; 
                
                $extra['route_id'] = $route_id;
                $extra['response_by_id'] = $driver_id;
                $extra['response_by_name'] = $driver->name;
                $extra['response_by_profile_pic'] = (\Helper::getUserMeta($driver_id, 'profile_pic', true) != '')?url(\Helper::getUserMeta($driver_id, 'profile_pic', true)):'';
                $extra['response'] = $action;

                $extra['shared_date'] = Carbon::parse($share_route->created_at)->format('Y-m-d H:i:s'); 

                $notification = \Helper::createNotification($share_route->share_by, $title, $desc, $type, json_encode($extra), '');
                
            }
            
            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            return response()->json($response);
        }
    }


    public function startFollowingRoute(Request $request)
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

            $driver_route = DriverRoutes::where('id', $route_id)->first();
            
            if(!isset($driver_route) || empty($driver_route)) {
                // 
                $response['status'] = "fail";
                $response['message'] = "Route not found!";
                $response['data'] = [];

                return response()->json($response);
            }

            
            $current_following_route = DriverCurrentRoute::updateOrCreate(['driver_id' => $driver->id], [ 
                'route_id' => $driver_route->id,
                'route_name' => $driver_route->route_name,
                'route_coordinates' => $driver_route->route_coordinates
            ]);
            
            if ($current_following_route) {
                // code...
                $current_following_route->route_coordinates = json_decode($current_following_route->route_coordinates);
                $response['status'] = "success";
                $response['message'] = "Current Route Set successfully!";
                $response['data'] = $current_following_route;
            }

            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }

    public function endFollowingRoute(Request $request)
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

            $current_following_route = DriverCurrentRoute::where('route_id', $route_id)->where('driver_id', $driver->id)->delete();

            if($current_following_route) {
                $response['status'] = "success";
                $response['message'] = "Current route end successfully!";
                $response['data'] = [];
            }

            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


    public function singleDriverInformation(Request $request)
    {
        // code...
        try {
            
            if (Auth::guard('api')->check()) {
                $login_user = Auth::guard('api')->user();
            }
            if(!$login_user) {
                return response()->json(['status' => false, 'message' => 'login token error!']);
            }

            $parameters = $request->all();
            extract($parameters);

            $driver = User::where('id', $driver_id)
                            // ->leftJoin('driver_current_route', 'users.id', '=', 'driver_current_route.driver_id')
                            // ->select('users.*', 'driver_current_route.route_name', 'driver_current_route.route_id', 'driver_current_route.route_coordinates')
                            ->first();

            if($driver) {
                $response['status'] = "success";
                $response['message'] = "Single Driver Information!";

                $current_following_route = DriverCurrentRoute::where('driver_id', $driver->id)->first();
                if(!empty($current_following_route)) {
                    // 
                    $driver->current_route_id = $current_following_route->route_id;
                    $driver->current_route_name = $current_following_route->route_name;
                    $driver->current_route_coordinates = json_decode($current_following_route->route_coordinates);
                }
                
                $response['data'] = $driver;
            }

            return response()->json($response);

        } catch(Exception $e) {
            $response['status'] = "fail";
            $response['message'] = "Error: ".$e;
            $response['data'] = [];
            return response()->json($response);
        }
    }


}
