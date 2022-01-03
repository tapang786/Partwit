@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
           {{$title}}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.category.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <input type="hidden" name="id" value="{{isset($category) ? $category->id : ''}}" >
                <label for="name">Title*</label>
                <input type="text" id="name" name="title" class="form-control" value="{{isset($category) ? $category->title : ''}}" required>
               
            </div>
            {{-- <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Parent Category*</label>
               <select class="form-control select2" name="parent">
               <option value="0">Select</option>
                   @foreach($parent_cat as $val)
                   <option value="{{$val->id}}" {{isset($category) && ($category->parent_id == $val->id) ? 'selected' : ''}}>{{$val->title}}</option>
                   @endforeach
               </select>
               
            </div> --}}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Description*</label>
                <textarea class="form-control" name="description" value="" required>{{isset($category) ? $category->description : ''}}</textarea>
            </div>
           
           
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
