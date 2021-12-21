<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reports;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('reports_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reports = Reports::all();
        $data['title'] = 'Reports';
        $data['reports'] = $reports;
        // dd(json_decode($reports[0]->extra_data)->product);
        foreach ($reports as $key => $value) {
            // code...
            $reports[$key]->extra_data = json_decode($value->extra_data);
        }
        // dd($reports);
        return view('admin.reports.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('reports_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reports.create');
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

        $report = Reports::updateOrCreate(
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

        return redirect()->route('admin.reports.index');
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
        abort_if(Gate::denies('reports_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $report = Reports::where('id', $id)->first();

        $data['title'] = 'Edit Report';
        $data['report'] = $report;
            
        return view('admin.reports.create', $data);
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
        abort_if(Gate::denies('reports_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advertisement->delete();

        return back();
    }
}
