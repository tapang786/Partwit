<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

        $sellerInfo['rating'] = isset($sellerInfo['rating']) ? $sellerInfo['rating'] : '0' ;
        $sellerInfo['profile_pic'] = ($sellerInfo['profile_pic'] != "")?url($sellerInfo['profile_pic']):url('images/placeholder.png');
        return $sellerInfo;

    }
}
