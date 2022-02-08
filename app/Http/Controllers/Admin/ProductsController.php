<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Categories;
use App\User;
use App\Attributes;
use App\AttributeValue;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('product_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = Product::join('users','users.id','=','products.seller_id')
                        ->select('products.*', 'users.name as seller')
                        ->with('category')
                        ->get();
        // dd($products[0]->category->title);

        $data['title'] = 'Products';
        $data['products'] = $products;
        return view('admin.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        

        return view('admin.products.create');
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
        // dd($request);
        if(isset($request->banner_image)) {
            $fileName = time().'_banner_'.$request->banner_image->getClientOriginalName();
            $request->banner_image->move(base_path('images/product'), $fileName);

            if(file_exists(base_path('images/product/'.$request->banner_image_old)) && isset($request->banner_image_old)) { 
                unlink(base_path('images/product/'.$request->banner_image_old));
            }

        } else {
            $fileName = $request->banner_image_old;
        }

        $args = [
            "name"          => $request->title,
            "seller_id"     => $request->seller_id,
            "short_desc"    => $request->short_desc,
            "description"   => $request->description,
            "price"         => $request->price,
            "category_id"   => $request->category,
            "listed_on"     => $request->listed_on,
            "expires_on"    => $request->expires_on,
            "status"        => $request->status,
        ];

        // if(!isset($request->pro_id)) {
        //     // 
        //     $listed_on = \Carbon\Carbon::now();
        //     $expires_on = \Carbon\Carbon::now()->addDays(15);

        //     $args["listed_on"] = $listed_on;
        //     $args["expires_on"] = $expires_on;
        // }

        $product = Product::updateOrCreate(['id' => $request->pro_id], $args);

        $featured_image = "";
        $all_images = [];


        

        if(!empty($request->featured_image) && $request->featured_image != null){
            // 
            if($request->hasFile('featured_image')) {
                // 
                $originName = $request->file('featured_image')->getClientOriginalName();
                $featured_image = time().'-'.$originName;  
                $request->featured_image->move(base_path('images/product/'), $featured_image);

                $featured_image = 'images/product/'.$featured_image;
                // $featured_image = $fileName.'_'.time().'.'.$extension;
            
                // $request->file('featured_image')->move(base_path('images/product/'), $fileName);
                
            }

            if(file_exists(base_path($product->featured_image)) && isset($request->featured_image)) { 
                unlink(base_path($product->featured_image));
            }
        } else {
            // 
            $featured_image = $product->featured_image;
        }

            

        // if(!empty($request->all_images) && $request->all_images != null){
        //     // 
        //     foreach ($request->all_images as $g_key => $g_value) {
        //         // 
        //         $all_images[] = $this->createImage($g_value);
        //     }

        //     $all_image = json_encode($all_images);

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
        //     $all_image = $product->all_images;
        // }

        Product::where('id','=',$product->id)->update([
            'featured_image' => $featured_image,
            // 'all_images' => $all_image
        ]);

        // return response()->json([
        //     'status' => true, 
        //     'message' => isset($request->pro_id) ? 'Product Updated!' : 'Product Created!'
        // ]);

        return redirect()->route('admin.products.index')->with('success', 'Product Updated!');
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
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Categories::all();
        $product = Product::where('id', $id)->first();
        $Attributes = Attributes::with('values')->where('cat_id', $product->category_id)->get();
        $data['title'] = 'Edit Product';
        $product['seller'] = User::select('name')->where('id', $product->seller_id)->first();
        $data['product'] = $product;
        $data['categories'] = $categories;
        $data['attributes'] = $Attributes;
        $data['attributes_data'] = json_encode(Attributes::with('values')->where('cat_id', $product->category_id)->get()->toArray());
        // dd(json_encode($attributes_data));

        return view('admin.products.create', $data);
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
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product = Product::where('id', $id)->first();
        $product->delete();

        return back();
    }

    public function getAttributes(Request $request)
    {
        //
        $attributes = Attributes::where('cat_id', $request->category)->get();
        $html = '';
        foreach ($attributes as $ky => $attribute) {
            // code...
            $html .='<option value="'.$attribute->id.'">'.$attribute->title.'</option>';
        }
        
        return response()->json(array('status'=> true, 'html' => $html), 200);
        // $Attributes = Attributes::with('values')->whereIn('id', $request->attributes)->get();
    }

    public function getAttributesValues(Request $request)
    {
        //
        $attributes = Attributes::with('values')->whereIn('id', $request->attribute_list)->get();
        $html = '';
        foreach ($attributes as $ky => $attribute) {
            // code...
            $html .='<div class="col-md-4" id="'.$attribute->id.'">
                        <span class="remove_attribute" attr-id="'.$attribute->id.'"><i class="far fa-times-circle"></i></span>
                        <div class="form-group">
                            <label for="featured_image">'.$attribute->title.'</label>
                            <select class="form-control attributes" name="attributes_value['.$attribute->id.']">
                            <option value="">Select Value</option>';
                            foreach($attribute->values as $k => $value) {
                                $html .='<option value="'.$value->id.'">'.$value->title.'</option>';
                            }
                           
            $html .='</select>
                            
                        </div>
                    </div>';
        }
        
        return response()->json(array('status'=> true, 'html' => $html), 200);
        // $Attributes = Attributes::with('values')->whereIn('id', $request->attributes)->get();
    }
}
