<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Product;
use App\Reports;
use DB;

use App\Helper;
use Carbon\Carbon;
use Hash;
use App\Mail\UserOtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use App\UserVerificationToken;

use App\Mail\UserMail;

class ProductsController extends Controller
{

    public function create(Request $request) {

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }
        if(!$user) {
            return response()->json(['status' => false, 'message' => 'login token error!']);
        }
        $seller_id = $user->id;

        $parameters = $request->all();
        extract($parameters);

        try {

            $validator = \Validator::make($request->all() , [
                'name'              => 'required', 
                'short_desc'        => 'required',
                'description'       => 'required',
                'price'             => 'required',
                'category_id'       => 'required',
                'featured_image'    => 'required',
                'all_images'        => 'required'
            ]);


            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $args = [
                "name"          => $request->name,
                "seller_id"     => $seller_id,
                "short_desc"    => $request->short_desc,
                "description"   => $request->description,
                "price"         => $request->price,
                "category_id"   => $request->category_id,
            ];

            if(!isset($request->pro_id)) {
                // 
                $listed_on = \Carbon\Carbon::now();
                $expires_on = \Carbon\Carbon::now()->addDays(15);

                $args["listed_on"] = $listed_on;
                $args["expires_on"] = $expires_on;
            }

            $product = Product::updateOrCreate(['id' => $request->pro_id], $args);

            $featured_image = "";
            $all_images = [];

            if(!empty($request->featured_image) && $request->featured_image != null){
                // 
                $featured_image = $this->createImage($request->featured_image);

                if(file_exists(base_path($product->featured_image)) && isset($request->featured_image)) { 
                    unlink(base_path($product->featured_image));
                }
            } else {
                // 
                $featured_image = $product->featured_image;
            }

            

            if(!empty($request->all_images) && $request->all_images != null){
                // 
                foreach ($request->all_images as $g_key => $g_value) {
                    // 
                    $all_images[] = $this->createImage($g_value);
                }

                $all_image = json_encode($all_images);

                if($product->all_images != "" || $product->all_images != null) {
                    // 
                    $all_images_old = json_decode($product->all_images);
                    foreach ($all_images_old as $image) {
                        // code...
                        if(file_exists(base_path($image)) && isset($image)) { 
                            unlink(base_path($image));
                        }
                    }
                }

            } else {
                // 
                $all_image = $product->all_images;
            }

            Product::where('id','=',$product->id)->update([
                'featured_image' => $featured_image,
                'all_images' => $all_image
            ]);

            return response()->json([
                'status' => true, 
                'message' => isset($request->pro_id) ? 'Product Updated!' : 'Product Created!'
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }

    public function show(Request $request) {

        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'User not login!']);
            }

            $validator = \Validator::make($request->all() , [
                'pro_id' => 'required', 
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $product =  Product::where('id',$pro_id)->first();

            $product->view_count++;
            $product->save();
            unset($product['view_count']); 

            $serller_info = User::where('id', $product->seller_id)->first();
            $serller_info = $this->sellerProfile($serller_info);

            $product->serller_info = $serller_info;

            $product->featured_image = ($product->featured_image) ? url($product->featured_image) : '';

            $product->listed_on =  Carbon::parse($product->listed_on)->format('m/d/Y');
            $product->expires_on =  Carbon::parse($product->expires_on)->format('m/d/Y');

            if($product->all_images != "" || $product->all_images != null) {
                $all_images = json_decode($product->all_images);
                $images = [];
                foreach ($all_images as $image) {
                    // code...
                    $images[] = url($image);
                }
            } else {
                $images = [];
            }
            $product->all_images = $images;

            return response()->json([
                'status' => true, 
                'message' => 'success',
                'data' =>$product
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }

    
    public function ReportProduct(Request $request)
    {
        // code...

        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'User not login!']);
            }

            $validator = \Validator::make($request->all() , [
                'product_id' => 'required',
                'reason' => 'required',
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $product = Product::where('products.id', $product_id)
                            ->join('users', 'users.id', '=', 'products.seller_id')
                            ->select('products.name as product_name', 'users.name as seller_name')
                            ->first();
            // dd($product);
            $report = Reports::create([
                'type' => 'product_report',
                'product_id' => $product_id,
                'user_id' => $user->id,
                'reason' => $reason,
                'description' => isset($more_details)?$more_details:'',
                'status' => 'initial',
                'extra_data' => json_encode([
                    'product' => $product->product_name, 
                    'seller_name' => $product->seller_name,
                    'seller_id' => $product->seller_name,
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                ]),
            ]);

            return response()->json([
                'status' => true, 
                'message' => 'Report Submited Successfully!',
                // 'data' => $report
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }


    public function delete(Request $request) {
        // code...

        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'User not login!']);
            }

            $validator = \Validator::make($request->all() , [
                'product_id' => 'required', 
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);

            $product_delete =  Product::where('id',$product_id)->delete();

            if($product_delete) {
                $status = true;
                $msg = 'Product deleted!';
            } else {
                $status = false;
                $msg = 'Can\'t delete!';
            }

            return response()->json([
                'status' => true, 
                'message' => $msg
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }

}
