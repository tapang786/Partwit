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
            
            {{-- <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                
                <label for="name">Category*</label>
                @if(!isset($category->id)) 
                    <select class="form-control select2" name="category">
                        <option value="0">Select</option>
                        @foreach($parent_cat as $val)
                        <option value="{{$val->id}}" {{isset($category) && ($category->id == $val->id) ? 'selected' : ''}}>{{$val->title}}</option>
                        @endforeach
                    </select>
                @else
                    <select class="form-control select2" name="category">
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    </select>
                @endif
            </div> --}}
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
