<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Product;
use App\Reports;
use DB;
use Log;
use App\Helper;
use Carbon\Carbon;
use Hash;
use App\Mail\UserOtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\UserVerificationToken;
use App\Mail\UserMail;
use App\Categories;
use App\Attributes;
use App\AttributeValue;
use App\ProductAttribute;

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

        // $all_images = json_decode($all_images);
        // Log::info($all_images);
        // exit;

        $product_attributes = json_decode($product_attributes);
        $attributes_value = json_decode($attributes_value);

        if(isset($deleted)) {
            $deleted = json_decode($deleted);
        }

        try {

            if(!isset($request->pro_id)) {
                $current_mpc = Product::whereMonth('created_at', Carbon::now()->month)
                                ->where('seller_id', $seller_id)
                                ->get()
                                ->count();

                $user = User::with('plan', 'subscription')->where('id', $seller_id)->first();

                if(isset($user->plan->end_date)) {
                    // 
                    $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $user->plan->end_date);
                    $date2 = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
                    $result = $date1->gt($date2);

                    if($date1->lt($date2)) {
                        return response()->json(['status' => false, 'message' => 'Your Subscription is expire!']);
                    } 
                }

                $product_limit = isset($user->subscription->product_limit)?$user->subscription->product_limit:3;
                if($current_mpc >= $product_limit) {
                    return response()->json(['status' => false, 'message' => 'You cant add more in this month!']);
                }
            }

            $validator = \Validator::make($request->all() , [
                'name'                  => 'required', 
                'short_desc'            => 'required',
                'description'           => 'required',
                'price'                 => 'required',
                'category_id'           => 'required',
                'product_attributes'    => 'required',
                'attributes_value'      => 'required',
                // 'featured_image'        => 'required',
                // 'all_images'            => 'required'
            ]);


            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }


            $args = [
                "name"          => $name,
                "seller_id"     => $seller_id,
                "short_desc"    => $short_desc,
                "description"   => $description,
                "price"         => $price,
                "category_id"   => $category_id,
            ];

            if(!isset($request->pro_id)) {
                // 
                $status = true;
                $listed_on = \Carbon\Carbon::now();
                $expires_on = \Carbon\Carbon::now()->addDays(15);

                $args["listed_on"] = $listed_on;
                $args["expires_on"] = $expires_on;
                $args["status"] = $status;
            }

            $product = Product::updateOrCreate(['id' => $request->pro_id], $args);

            $ProductAttribute = ProductAttribute::where('product_id', $product->id)->delete();

            // Assign Attributes and Values //
            // $product_attributes = $request->product_attributes;
            // $attributes_value = $request->attributes_value;
            $category = Categories::where('id', $category_id)->first();

            foreach ($product_attributes as $key => $attribute) {
                // code...
                $vl = AttributeValue::with('attributes')->where('id', $attributes_value[$key])->first();

                ProductAttribute::create([
                    'product_id' => $product->id,
                    'category_id' => $product->category_id,
                    'attribute_id' => $attribute,
                    'attribute_value_id' => $attributes_value[$key],
                    'category_title' => $category->title,
                    'attribute_title' => $vl->attributes->title,
                    'value_title' => $vl->title,
                ]);
            }
            // 

            $gallery_images = [];            

            if(!empty($all_images) && $all_images != null){
                // 
                $all_images = json_decode($all_images);

                foreach ($all_images as $g_key => $g_value) {
                    // 
                    $gallery_images[] = $this->createImage($g_value);
                }  
            }
            // else {
            //     // 
            //     $gallery_images = $product->all_images;
            // }

            if(isset($product->all_images) && ($product->all_images != "" || $product->all_images != null)) {
                // 
                if(isset($deleted)) {
                    // 

                    $all_images_old = json_decode($product->all_images);
                    foreach ($all_images_old as $key => $image) {
                        // code...

                        if(in_array($key, $deleted)) {
                            // 
                            unset($all_images_old[$key]);

                            if(file_exists(base_path($image)) && isset($image)) { 
                                unlink(base_path($image));
                            }
                        }
                    }
                } else {
                    // 
                    $all_images_old = json_decode($product->all_images);
                }
            } 

            if(isset($all_images_old)) {
                $gallery_images = array_merge($all_images_old, $gallery_images);
            }

            $gallery_images = json_encode($gallery_images);

            if(count(json_decode($gallery_images)) > 0){

                $featured_image = "";
                $featured_image = (count(json_decode($gallery_images)) > 0)?json_decode($gallery_images)[0]:$product->featured_image;

                Product::where('id','=',$product->id)->update([
                    'featured_image' => $featured_image,
                    'all_images' => $gallery_images
                ]);
            }


            // if($request->hasfile('all_images'))
            // {   
            //     $gallery_images = [];
            //     foreach($request->file('all_images') as $key => $file)
            //     {
            //         $name = uniqid()."_".$key. 'gallery_image.' . $file->extension();
            //         $file->move(base_path().'/images/product/', $name);  
            //         $gallery_images[] = "images/product/".$name;  
            //     }

            //     $gallery_images = json_encode($gallery_images);

            //     if($product->all_images != "" || $product->all_images != null) {
            //         // 
            //         $all_images_old = json_decode($product->all_images);
            //         foreach ($all_images_old as $image) {
            //             // code...
            //             if(file_exists(base_path($image)) && isset($image)) { 
            //                 unlink(base_path($image));
            //             }
            //         }
            //     }
                
            // } else {
            //     // 
            //     $gallery_images = $product->all_images;
            // }


            

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
            if(!$product) {
                return response()->json(['status' => false, 'message' => 'Product not found!']);
            }
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
            $ProductAttribute = ProductAttribute::where('product_id', $product_id)->delete();

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


    public function editProduct(Request $request)
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
            ]);

            if ($validator->fails()) {
                $response = $validator->errors();
                return response()
                    ->json(['status' => false, 'message' => implode("", $validator->errors()
                    ->all()) ], 200);
            }

            $parameters = $request->all();
            extract($parameters);


            
            $product = Product::where('id', $product_id)->first();

            if(!$product) {
                return response()
                    ->json(['status' => false, 'message' => 'Product not found!'], 200);
            }

            $attributes = Attributes::with('values')->where('cat_id', $product->category_id)->get();

            $product_attributes = ProductAttribute::where('product_id', $product->id)->pluck('attribute_value_id', 'attribute_id')->toArray();
            

            foreach($attributes as $k => $attribute) {
                // 
                if (array_key_exists($attribute->id, $product_attributes)) {
                    $attribute['selected'] = true;
                } else {
                    $attribute['selected'] = false;
                }

                unset($attribute->cat_id);
                unset($attribute->created_at);
                unset($attribute->updated_at);
                unset($attribute->deleted_at);

                foreach($attribute->values as $ak => $attribute_value) {
                    if (in_array($attribute_value->id, $product_attributes))
                    { 
                        $attribute_value['selected'] = true;
                    } else {
                        $attribute_value['selected'] = false;
                    }
                    unset($attribute_value->created_at);
                    unset($attribute_value->updated_at);
                    unset($attribute_value->deleted_at);
                    unset($attribute_value->attr_id);
                    unset($attribute_value->cat_id);
                }
                $attribute[$attribute->title] = $attribute->values;

                unset($attribute->values);
            }


            // $Attributes = Attributes::with('values')->where('cat_id', $product->category_id)->get();

            $product['seller'] = User::select('name')->where('id', $product->seller_id)->first();
            if(isset($product->all_images)) {
                $imgs = [];
                foreach (json_decode($product->all_images) as $key => $img) {
                    // code...
                    $imgs[] .= url($img);
                }
                $product['all_images'] = $imgs;
            }
            if(isset($product->featured_image)) {
                $product['featured_image'] = url($product->featured_image);
            }

            $product_attributes = [];
            $Attributes = ProductAttribute::where('product_id', $product_id)->get()->toArray();
            foreach($Attributes as $k => $Attribute) {
                $product_attributes[$Attribute['attribute_id']] =  $Attribute;
            }
            $product['categories'] = Categories::all();
            $product['product_attributes'] = $attributes; 


            $product_attributes = ProductAttribute::where('product_id', $product->id)->pluck('attribute_value_id', 'attribute_id')->toArray();
            $attributes = Attributes::with('values')->where('cat_id', $product->category_id)->get();
            foreach ($attributes as $key => $attribute) {
                // 
                if (array_key_exists($attribute->id, $product_attributes)) {
                    $attribute['selected'] = true;
                } else {
                    $attribute['selected'] = false;
                }
                $data[] = $attribute;
                foreach ($attribute->values as $ky => $value) {
                    // code...
                    if (in_array($value->id, $product_attributes))
                    { 
                        $value['selected'] = true;
                    } else {
                        $value['selected'] = false;
                    }
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
            $product['attributes'] = $attributes;

            return response()->json([
                'status' => true, 
                'message' => 'Edit Product!',
                'data' => $product, 
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }


    public function filtersData(Request $request)
    {
        // code...
        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'User not login!']);
            }

            // $validator = \Validator::make($request->all() , [
            //     'category_id' => 'required', 
            // ]);

            // if ($validator->fails()) {
            //     $response = $validator->errors();
            //     return response()
            //         ->json(['status' => false, 'message' => implode("", $validator->errors()
            //         ->all()) ], 200);
            // }

            $parameters = $request->all();
            extract($parameters);

            if(!isset($category_id)) {
                $category_id = Categories::first()->id;
            }

            $attributes = Attributes::with('values')->where('cat_id', $category_id)->get();
            

            // $Attributes = Attributes::where('cat_id', $category_id)->get();
            
            foreach($attributes as $key => $val ){
                
                unset($val->created_at);
                unset($val->updated_at);
                unset($val->deleted_at);
                unset($val->cat_id);

                foreach ($val->values as $k => $value) {
                    // code...
                    unset($value->created_at);
                    unset($value->updated_at);
                    unset($value->deleted_at);
                    unset($value->cat_id);
                    unset($value->attr_id);
                }
                $val[$val->title] = $val->values;
                unset($val->values);
            }

            $data['attributes'] = $attributes;

            $data['year_range'][0]['min_year'] = Carbon::parse(Product::where('category_id', $category_id)->oldest()->first()->created_at)->format('Y');
            $data['year_range'][1]['max_year'] = Carbon::parse(now())->format('Y');

            $data['price_range'][0]['min_price'] = Product::where('category_id', $category_id)->where('price','>=', 0)->min('price');
            $data['price_range'][1]['max_price'] = Product::where('category_id', $category_id)->max('price');

            return response()->json([
                'status' => true, 
                'message' => 'Filter values',
                'data' => $data
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }

    public function filterProduct(Request $request)
    {
        // code...
        try {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if(!$user) {
                return response()->json(['status' => false, 'message' => 'User not login!']);
            }

            $parameters = $request->all();
            extract($parameters);

            $q = Product::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')->select('products.*', 'product_attributes.attribute_value_id as pa');
            
            if(isset($min_price) && isset($max_price)) {
                $q->whereBetween('products.price', [$min_price, $max_price]);
            }

            if(isset($year_from)) {
                $date = Carbon::createFromDate($year_from, 1, 1);
                $startOfYear = $date->copy()->startOfYear();
                $q->where('products.created_at', '>=', $startOfYear->format('Y-m-d H:i:s'));
            }
            if(isset($year_to)) {
                $date = Carbon::createFromDate($year_to, 1, 1);
                $endOfYear   = $date->copy()->endOfYear();
                $q->where('products.created_at', '<=', $endOfYear->format('Y-m-d H:i:s'));
            }

            if(isset($attributes_value)) {
                $attributes_value = json_decode($attributes_value);

                $q->whereIn('product_attributes.attribute_value_id', $attributes_value);
            }
            $q->groupBy('products.id');
            $products = $q->get();
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

            return response()->json([
                'status' => true, 
                'message' => (count($product_lists) > 0)?'Product list!':'No product found',
                'data' => (count($product_lists) > 0)?$product_lists:[],
            ]);

        } catch (Exception $e){
            return response()->json(['status' => false, 'message' => "Error: ".$e], 200);
        }
    }

}
