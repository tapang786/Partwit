<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Reviews;
use App\Notifications;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function createImage($img, $key = 0)
    {
        //var_dump($img);
        $folderPath = "images/product/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
         $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        //$image_type = '.jpg';
        $file = uniqid()."_".$key. 'gallery_image.' . $image_type;
        file_put_contents("images/product/".$file, $image_base64);
        return "images/product/".$file;

    }

    public function addNotification($user_id=0, $type, $title='', $description='', $meta, $status='new') {
        // code...
        $notification = Notifications::create([
            'user_id' => $user_id, 
            'type' => $type, 
            'title' => $title, 
            'description' => $description, 
            'meta' => $meta, 
            'status' => $status, 
        ]);

        if($notification) {
            return true;
        } else {
            return false;
        }
    }

    public function sellerProfile($sellerInfo)
    {
        // code...
        $sellerInfo = json_decode($sellerInfo, true);
        $keys = array("id", "name", "rating", "profile_pic");
        foreach ($sellerInfo as $key => $value) {
            // code...
            if (!in_array($key, $keys))
            {
                unset($sellerInfo[$key]);
            }
        }

        $rating_sum = Reviews::where('seller_id', $sellerInfo['id'])->sum('stars');
        $rating_total = Reviews::where('seller_id', $sellerInfo['id'])->count();
        // dd($rating_total);
        if($rating_sum > 0 && $rating_total > 0) {
            $rating = $rating_sum / $rating_total;
        } else {
            $rating = 0;
        }

        $sellerInfo['rating'] = $rating ;
        $sellerInfo['profile_pic'] = ($sellerInfo['profile_pic'] != "")?url($sellerInfo['profile_pic']):url('images/placeholder.png');
        return $sellerInfo;

    }
}
