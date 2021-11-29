@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.create') }} {{ trans('cruds.city.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.city.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('city_name') ? 'has-error' : '' }}">
                <label for="city_name">{{ trans('cruds.city.fields.city_name') }}*</label>
                <input type="text" id="city_name" name="city_name" class="form-control" value="{{ old('city_name', isset($city) ? $city->city_name : '') }}" required>
                @if($errors->has('city_name'))
                    <p class="help-block">
                        {{ $errors->first('city_name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.city.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('city_code') ? 'has-error' : '' }}">
                <label for="city_code">{{ trans('cruds.city.fields.city_code') }}*</label>
                <input type="text" id="city_code" name="city_code" class="form-control" value="{{ old('city_code', isset($city) ? $city->city_code : '') }}" required>
                @if($errors->has('city_code'))
                    <p class="help-block">
                        {{ $errors->first('city_code') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.city.fields.title_helper') }}
                </p>
            </div>

            <div>
                <input type="hidden" value="{{ isset($city->id)? $city->id: ''}}" name="id">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
