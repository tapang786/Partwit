<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Advertisement;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('advertisement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $advertisements = Advertisement::all();
        return view('admin.advertisement.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('advertisement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.advertisement.create');
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
        
        //$fileName = time().'.'.$request->banner_image->extension();  

        if(isset($request->banner_image)) {
            $fileName = time().'_banner_'.$request->banner_image->getClientOriginalName();
            $request->banner_image->move(base_path('images/banners'), $fileName);

            if(file_exists(base_path('images/banners/'.$request->banner_image_old)) && isset($request->banner_image_old)) { 
                unlink(base_path('images/banners/'.$request->banner_image_old));
            }

        } else {
            $fileName = $request->banner_image_old;
        }

        $advertisement = Advertisement::updateOrCreate(
            [ 'id' => $request->id ],
            [
                'title' => $request->title, 
                'description' => $request->description?$request->description:'', 
                'start_at' => $request->start_at, 
                'end_at' => $request->end_at, 
                'status' => $request->status, 
                'banner_image' => $fileName, 
            ]
        );

        return redirect()->route('admin.advertisement.index');
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
        abort_if(Gate::denies('advertisement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advertisement = Advertisement::where('id', $id)->first();

        return view('admin.advertisement.create', compact('advertisement'));
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
    public function destroy(Advertisement $advertisement)
    {
        //
        abort_if(Gate::denies('advertisement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advertisement->delete();

        return back();
    }
}
