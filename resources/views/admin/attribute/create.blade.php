@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">{{$title ?? ''}}</h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.attributes.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <input type="hidden" name="id" value="{{isset($category) ? $category->id : ''}}" >
                <label for="name">Attribute Name*</label>
                <input type="text" id="name" name="title" class="form-control" value="{{isset($Attributes) ? $Attributes->title : ''}}" required>
               
            </div>
            
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                
                <label for="type">Type*</label>
                    <select class="form-control" name="type" id="attribute">
                        <option value="">Select Type</option>
                        <option value="text" {{(isset($Attributes) && $Attributes->type == 'text')?'selected':''}}>Text</option>
                        <option value="color" {{(isset($Attributes) && $Attributes->type == 'color')?'selected':''}}>Color</option> 
                    </select>
            </div>
            <br>
            <div>
                <input type="hidden" name="attr_id" value="{{isset($Attributes) ? $Attributes->id : ''}}" >
                <input type="hidden" name="category" value="{{isset($_GET['cat'])?$_GET['cat']:0}}">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
