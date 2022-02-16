<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\Attributes;
use App\AttributeValue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttributeValueController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $d['title'] = 'Attribute Values';

        $q = AttributeValue::select('attributes.title as attribute', 'attributes.id as attr_id', 'attributes_value.*')->leftJoin('attributes', 'attributes_value.attr_id', '=', 'attributes.id');
        if(isset($_GET['attr'])) {
            $q->where('attr_id', $_GET['attr']);
        }
        $attributes = $q->get();
        $d['attributes'] = $attributes;

        if(!isset($_GET['cat']) || $_GET['cat'] == "" || !isset($_GET['attr']) || $_GET['attr'] == "") {
            // 
            return redirect()->route('admin.category.index');
        }

        return view('admin.attribute-value.index', $d);
    }

    public function create()
    {
       
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $d['title'] = 'Add Attribute Value';
        $d['Attributes'] = Attributes::all();
        return view('admin.attribute-value.create',$d);
    }

    public function store(Request $request)
    {
        $attribute = AttributeValue::updateOrCreate(['id'=>$request->id],[
            'attr_id' => $request->attribute,
            'cat_id' => $request->category,
            'title'     => $request->title,
            'type'  => isset($request->type)?$request->type:'text',
            'color' => isset($request->color)?$request->color:'',
        ]);

        return redirect()->route('admin.attribute-value.index', ['attr' => $request->attribute, 'cat' => $request->category]);

    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $d['title'] = 'Edit Attribute Value';
        $d['attributeValue'] = AttributeValue::where('id', $id)->first();
        // $d['parent_cat'] = Categories::where('parent_id','=',0)->get();
        // $d['category'] = Categories::where('id','=',$id)->first();

        return view('admin.attribute-value.create', $d);
    }

  

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attr = AttributeValue::where('id','=',$id)->first();

        $attr->delete();

        return back();

    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Categories::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
