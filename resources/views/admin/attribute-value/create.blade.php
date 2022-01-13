@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{$title ?? ''}}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.attribute-value.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <br>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                
                <label for="name">Attribute Value*</label>
                <input type="text" id="name" name="title" class="form-control" value="{{isset($attributeValue) ? $attributeValue->title : ''}}" required>
                {{-- <small>Add Multiple Values separated by a comma.</small> --}}
            </div>
            <br>
            {{-- <div class="form-group {{ $errors->has('attribute') ? 'has-error' : '' }}">
                <label for="attribute">Attribute *</label>
                <select class="form-control select2" name="attribute">
                    <option value="0">Select</option>
                    @foreach($Attributes as $val)
                    <option value="{{$val->id}}">{{$val->title}}</option>
                    @endforeach
                </select>
            </div> --}}
            <br>
            
            <div>
                <input type="hidden" name="category" value="{{ $_GET['cat']}}" >
                <input type="hidden" name="attribute" value="{{ $_GET['attr']}}" >
                <input type="hidden" name="id" value="{{isset($attributeValue) ? $attributeValue->id : ''}}" >

                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
