@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.create') }} {{ trans('cruds.advertisement.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.advertisement.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.advertisement.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($advertisement) ? $advertisement->title : '') }}" required>
                @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.advertisement.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.advertisement.fields.description') }}</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($advertisement) ? $advertisement->description : '') }}">
                @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.advertisement.fields.title_helper') }}
                </p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('start_at') ? 'has-error' : '' }}">
                        <label for="start_at">{{ trans('cruds.advertisement.fields.start_at') }}*</label>
                        @php $start_at = isset($advertisement) ? \Carbon\Carbon::parse($advertisement->start_at)->format('Y-m-d') : '' ; @endphp
                        <input type="date" id="start_at" name="start_at" class="form-control" value="{{ old('start_at', $start_at) }}" required>
                        @if($errors->has('start_at'))
                            <p class="help-block">
                                {{ $errors->first('start_at') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('end_at') ? 'has-error' : '' }}">
                        <label for="end_at">{{ trans('cruds.advertisement.fields.end_at') }}*</label>
                        @php $end_at = isset($advertisement) ? \Carbon\Carbon::parse($advertisement->end_at)->format('Y-m-d') : '' ; @endphp
                        <input type="date" id="end_at" name="end_at" class="form-control" value="{{ old('end_at', $end_at) }}" required>
                        @if($errors->has('end_at'))
                            <p class="help-block">
                                {{ $errors->first('end_at') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('banner_image') ? 'has-error' : '' }}">
                        <label for="banner_image">{{ trans('cruds.advertisement.fields.banner_image') }}*</label>
                        <input type="file" id="banner_image" name="banner_image" class="form-control" value="" {{ isset($advertisement->banner_image) ? '' : 'required' }}>
                        @if($errors->has('banner_image'))
                            <p class="help-block">
                                {{ $errors->first('banner_image') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                        @if(isset($advertisement->banner_image)) 
                            <img src="{{ url('images/banners/'.$advertisement->banner_image)}}" width="220">
                        @endif
                        <input type="hidden" name="banner_image_old" value="{{ isset($advertisement->banner_image) ? $advertisement->banner_image : '' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">{{ trans('cruds.advertisement.fields.status') }}*</label>
                        @php $status = (isset($advertisement->status) ? $advertisement->status : ''); @endphp
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="1" {{ ($status == 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ ($status == 0) ? 'selected' : '' }}>In active</option>
                        </select>
                        
                        @if($errors->has('status'))
                            <p class="help-block">
                                {{ $errors->first('status') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                        
                    </div>
                </div>
            </div>
                        

            <div>
                <input type="hidden" value="{{ isset($advertisement->id)? $advertisement->id: ''}}" name="id">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
