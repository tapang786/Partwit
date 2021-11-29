<?php // Code within app\Helpers\Helper.php
namespace App;
use Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\OrderMeta;

use App\Subscription;
use App\UserSubscription;
use Carbon\Carbon;
use App\Notifications;


class Helper
{
    public static function createImage($img, $user_id = 0)
    {

        $folderPath = "images/";
        $image_parts = explode(";base64,", $img);
        /*$image_type_aux = explode("image/", $image_parts[0]);
         $image_type = $image_type_aux[1];*/
        $image_base64 = base64_decode($img);
        $image_type = '.jpg';
        $file = $folderPath . uniqid()."_".$user_id. '_userprofile' . $image_type;
        file_put_contents($file, $image_base64);
        return $file;
        
    }

    // public static function addUserImages($imgs=array(), $user_id=0)
    // {
    //     // code...
    //     $profile_images = json_decode(\Helper::getUserImages($user_id));
    //     if(empty($profile_images)) {
    //         $profile_images = [];
    //     }
        
    //     $i = count($profile_images);
    //     foreach ($imgs as $key => $value) {
    //         // code...
    //         if($i<6) {
    //             $img = \Helper::createImage($value, $user_id);
    //             $profile_images[] = $img;
    //         }
    //         $i++;
    //     }
        
    //     return json_encode($profile_images);
    // }

    // public static function getUserImages($user_id)
    // {
    //     // code...
    //     $profile_images = UserMeta::where('user_id', $user_id)->where('key','=','profile_images')->select('value')
    //         ->pluck('value')
    //         ->first();
    //     return $profile_images;
    // }

    public static function update_user_meta($id, $meta_key="", $meta_value) {
        //
        try {
            UserMeta::updateOrCreate([
                    'user_id' => $id, 
                    'key' => $meta_key,
                ], [ 'value' => $meta_value ]
            );
            return true;
        }
        catch(Exception $e) {
            return $e;
        }
    }

    public static function getUserInfo($user_id)
    {
        if(!$user_id) {
            return '';
        } else {
            // 
            $user_info = User::where('id', $user_id)->first();
            if($user_info) {
                return $user_info;
            } else {
                return '';
            }
        }

    }

    public static function getUserMeta($id, $key="", $status = false)
    {
        if (empty($key)) {
            // 
            $userdetailsadd = UserMeta::where('user_id', $id)->select('key', 'value')
                ->pluck('value', 'key')
                ->toArray();
            return $userdetailsadd;
        }
        else {
            //
            if ($status) {
                // 
                $userdetailsadd = UserMeta::where('user_id', $id)->where('key', $key)->first();
                if (!empty($userdetailsadd))
                    return $userdetailsadd->value;
                else
                    return "";
            }
            else {
                $userdetailsadd = UserMeta::where('user_id', $id)->where('key', $key)->select('key', 'value')
                    ->pluck('value', 'key')
                    ->toArray();
                return $userdetailsadd;
            }
        }
    }

    public static function singleUserInfoDataChange($user_id, $values) {

        $profile_images = [];
        $metadetail = \Helper::getUserMeta($user_id);
        foreach ($metadetail as $key => $value) {
            // code...
            if("profile_images" != $key) {
                $values[$key] = $value;
            }
        }


        $values['profile_pic'] = (\Helper::getUserMeta($user_id, 'profile_pic', true) != "")?url(\Helper::getUserMeta($user_id, 'profile_pic', true)):url('images/placeholder.png');
        
        return $values;
    }

    public static function username_exists($key, $value)
    {
        // code...
        $user = User::where($key, '=', $value)->first();
        if($user) {
            return true;
        } else {
            return false;
        }
    }


    public static function get_user($key, $value)
    {
        // code...
        $user = User::where($key, '=', $value)->first();
        if($user) {
            return $user;
        } else {
            return false;
        }
    }

    public static function isUserBlocked($user_id=0) {
        // 
        if(!$user_id) {
            $response['status'] = false;
            $response['response'] = ['status' => 'fail', 'message' => 'user id not found!'];
        } else {
            $user = Auth::guard('api')->user();
            $slef_id = $user->id;

            $BlockedUsersTo = BlockedUsers::where('blocked_by', $slef_id)
                  ->where('blocked_to', $user_id)
                  ->first();

            $BlockedUsersBy = BlockedUsers::where('blocked_by', $user_id)
                  ->where('blocked_to', $slef_id)
                  ->first();

            if($BlockedUsersTo) {
                $response['status'] = true;
                $response['response'] = ['status' => 'fail', 'message' => 'User blocked by you!'];
            } else if($BlockedUsersBy){
                $response['status'] = true;
                $response['response'] = ['status' => 'fail', 'message' => 'User blocked you!'];
            } else {
                $response['status'] = false;
                $response['response'] = ['status' => 'fail', 'message' => 'User blocked you!'];
            }
        }
        return $response;
    }

    public static function sendNotification($send_to, $notification)
    {
        // 
        $firebaseToken = User::where('id', $send_to)->where('notification_status', 1)->pluck('device_id');
        

        $SERVER_API_KEY = '';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => $notification
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        if($response['success']) {
            return response()->json(['status' => true, 'message' => "Notification send successfully!"]);
        } else {
            return response()->json(['status' => true, 'message' => "Error!"]);
        }

    }

    public static function getDriverFriendStatus($user_id, $driver_id) {
        // 
        $friends_request = DriverFriends::where('send_to', $user_id)
                                                ->where('send_by', $driver_id)
                                                ->first();

        if(empty($friends_request)) {
            $friends_request = DriverFriends::where('send_to', $driver_id)
                                                ->where('send_by', $user_id)
                                                ->first();
        }

        if(empty($friends_request)) {
            return 'no friend';
        } else {
            return $friends_request->status;
        }

    }


    public static function updateUserSubscriptionPlan($user_id, $subscribe_id)
    {
        // code...

        $subscription = Subscription::find($subscribe_id);
        $start_date = Carbon::now();
        switch ($subscription->type) {
            case 'day':
                // code...
                $end_date = $start_date->addDays($subscription->number);
                break;
            case 'month':
                // code...
                $end_date = $start_date->addMonths($subscription->number);
                break;

            default:
                // code...
                $end_date = $start_date->addYears($subscription->number);
                break;
        }

        $user_subscription = UserSubscription::updateOrCreate(
            [ 'user_id' => $user_id ],
            [
                'subscription_id' => $subscription->id,
                'title' => $subscription->title, 
                'description' => $subscription->description?$subscription->description:'', 
                'price' => $subscription->price, 
                'start_date' => Carbon::now(), 
                'end_date' => $end_date, 
            ]
        );

        if($user_subscription) {
            return true; 
        } else {
            return false;
        }
    }


    public static function createNotification($user_id=0, $title="", $description="", $type="", $extra="")
    {
        // code...
        $status = false;
        $notification_id = Notifications::create([
            "user_id"           => $user_id,
            "title"             => $title,
            "description"       => $description,
            "type"              => $type,
            "extra"             => $extra,
        ])->id;

        if($notification_id) {
            $status = true; 
        } 
        return $status;
    }

}

