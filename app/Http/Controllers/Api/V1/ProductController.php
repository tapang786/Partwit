<?php

namespace App\Http\Controllers\Api;

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

        die('sdf');

        $validator = \Validator::make($request->all() , [
            // 'name' => 'required',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|confirmed|string|min:6'
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
