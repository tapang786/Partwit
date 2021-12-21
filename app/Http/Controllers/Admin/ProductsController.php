<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Gate;
use Symfony\Component\HttpFoundation\Response;


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
                        ->get();

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

        // $request->validate([
        //     'file' => 'required|mimes:pdf,xlx,csv|max:2048',
        // ]);

        if(isset($request->banner_image)) {
            $fileName = time().'_banner_'.$request->banner_image->getClientOriginalName();
            $request->banner_image->move(base_path('images/product'), $fileName);

            if(file_exists(base_path('images/product/'.$request->banner_image_old)) && isset($request->banner_image_old)) { 
                unlink(base_path('images/product/'.$request->banner_image_old));
            }

        } else {
            $fileName = $request->banner_image_old;
        }

        $subscription = Subscription::updateOrCreate(
            [ 'id' => $request->id ],
            [
                'title' => $request->title, 
                'type' => $request->type, 
                'number' => $request->number, 
                'description' => $request->description?$request->description:'', 
                'price' => $request->price, 
            ]
        );

        return redirect()->route('admin.products.index');
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

        $product = Product::where('id', $id)->first();
        $data['title'] = 'Edit Product';
        $data['product'] = $product;

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
    public function destroy(Subscription $subscription)
    {
        //
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription->delete();

        return back();
    }
}
