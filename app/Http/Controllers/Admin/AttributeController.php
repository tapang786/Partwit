<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\Attributes;
use App\Categories;
use App\AttributeValue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttributeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!isset($_GET['cat']) || $_GET['cat'] == "") {
            // 
            return redirect()->route('admin.category.index');
        }

        $d['title'] = 'Attributes';
        
        if(isset($_REQUEST['cat'])) {
            $cat = $_REQUEST['cat'];
            $Attributes = Attributes::where('cat_id', $cat)->get();
        } else {
            $Attributes = Attributes::all();
        }
        

        foreach($Attributes as $key => $val ){
            $cat = Categories::where('id','=',$val->cat_id)->first();
            $atrVal = AttributeValue::where('attr_id','=',$val->id)->get();
            $Attributes[$key]['name'] = $cat->title;
            $Attributes[$key]['cat_id'] = $cat->id;
            $Attributes[$key]['atrVal'] = $atrVal;
        }

        $d['Attributes'] = $Attributes;
        return view('admin.attribute.index', $d);
    }

    public function create($catId=null)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $d['title'] = 'Add Attributes';
        $d['parent_cat'] = Categories::where('parent_id','=',0)->get();

        return view('admin.attribute.create',$d);
    }

    public function store(Request $request)
    {
        $Attributes = Attributes::updateOrCreate(['id'=>$request->attr_id],[
            'title'     => $request->title,
            'cat_id'     => $request->category,
        ]);

        return redirect()->route('admin.attributes.index', ['cat' => $request->category]);

    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!isset($_GET['cat']) || $_GET['cat'] == "") {
            // 
            return redirect()->route('admin.category.index');
        }
        $d['title'] = 'Attributes';

        $d['parent_cat'] = Categories::all();

        $Attributes = Attributes::where('id','=',$id)->first();

        $d['category'] = Categories::where('id','=',$Attributes->cat_id)->first();
 
        $d['Attributes'] = $Attributes;

        return view('admin.attribute.create', $d);
    }

  

    public function show($attrid)
    {

        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attr = Attributes::where('id','=',$attrid)->first();
        
        $attrval = AttributeValue::where('attr_id','=',$attrid)->get();

        $d['attr'] = $attr;

        $d['attrval'] = $attrval;

        return view('admin.attribute.show', $d);
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attr = Attributes::where('id','=',$id)->first();

        $attr->delete();

        return redirect()->route('admin.attributes.index', ['cat' => $_GET['cat']]);

    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Categories::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
