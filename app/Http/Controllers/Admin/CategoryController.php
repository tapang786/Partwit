<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\Categories;
use App\Attributes;
use App\AttributeValue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $d['title'] = 'Attributes';

        $Attributes = Attributes::all();

        foreach($Attributes as $key => $val ){

            $cat = Categories::where('id','=',$val->id)->first();
            $atrVal = AttributeValue::where('attr_id','=',$val->id)->get();
            $Attributes[$key]['name'] = $cat->title;
            $Attributes[$key]['atrVal'] = $atrVal;
        }

        // foreach($category as $key => $val){
        //     $parent = Categories::where('id','=',$val->id)->where('parent_id','!=',0)->first();
        //     if(!empty($parent)){
        //         $category[$key]['parent_name'] = $parent->title;
        //     }
        // }
        //dd($Attributes);
        $d['Attributes'] = $Attributes;
        return view('admin.category.index', $d);
    }

    public function create($catId=null)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $d['title'] = 'Add Category';
        $d['parent_cat'] = Categories::where('parent_id','=',0)->get();


        return view('admin.category.create',$d);
    }

    public function store(Request $request)
    {
        $Categories = Categories::updateOrCreate(['id'=>$request->id],[

            'parent_id' => $request->parent,
            'title'     => $request->title,
            'description'     => $request->description,


        ]);

        return redirect()->route('admin.category.index');

    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $d['title'] = 'Edit Category';
        $d['parent_cat'] = Categories::where('parent_id','=',0)->get();
        $d['category'] = Categories::where('id','=',$id)->first();

        return view('admin.category.create', $d);
    }

  

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(Categories $category)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return back();

    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Categories::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
