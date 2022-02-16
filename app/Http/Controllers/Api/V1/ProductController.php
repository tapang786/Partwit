<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Product;
use DB;

use App\Helper;
use Carbon\Carbon;
use Hash;
use App\Mail\UserOtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use App\UserVerificationToken;

use App\Mail\UserMail;

class ProductController extends Controller
{

    public function create(Request $req){

        $validator = \Validator::make($request->all() , [
            // 'name' => 'required',
            'name' => 'required', 
            'seller_id' => 'required',
            'short_desc' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'featured_image' => 'required',
            'all_images' => 'required'
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()
                ->json(['status' => false, 'message' => implode("", $validator->errors()
                ->all()) ], 200);
        }

        Product::create([

            "name" => $req->name,
            "seller_id" => $req->name,
            "short_desc" => $req->name,
            "description" => $req->name,
            "price" => $req->name,
            "category_id" => $req->name,
        ]);

        return response()->json([
            'status' => true, 
            'message' => 'success'
        ]);


    }

}
