<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // abort_if(Gate::denies('advertisement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pages = Posts::where('type', 'page')->get();
        $data['title'] = 'Pages';
        $data['pages'] = $pages;
        // dd($pages);
        return view('admin.pages.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // abort_if(Gate::denies('advertisement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['title'] = 'New Pages';
        return view('admin.pages.create', $data);
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

        // if(isset($request->banner_image)) {
        //     $fileName = time().'_banner_'.$request->banner_image->getClientOriginalName();
        //     $request->banner_image->move(base_path('images/banners'), $fileName);

        //     if(file_exists(base_path('images/banners/'.$request->banner_image_old)) && isset($request->banner_image_old)) { 
        //         unlink(base_path('images/banners/'.$request->banner_image_old));
        //     }

        // } else {
        //     $fileName = $request->banner_image_old;
        // }

        $page = Posts::updateOrCreate(
            [ 'id' => $request->id ],
            [
                'title' => $request->title, 
                'description' => $request->description?$request->description:'', 
                // 'short_description' => $request->short_description?$request->description:'', 
                'user_id' => Auth::id(), 
                'status' => $request->status,
                'type' => 'page', 
            ]
        );

        return redirect()->route('admin.pages.index');
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
        // abort_if(Gate::denies('advertisement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page = Posts::where('id', $id)->first();
        $data['title'] = 'Edit Page';
        $data['page'] = $page;
        return view('admin.pages.create', compact('page'));
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
        //abort_if(Gate::denies('advertisement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page = Posts::where('id', $id)->first();
        $page->delete();

        return back();
    }
}
