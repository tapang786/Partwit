@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ $title }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.vendor-store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @if($errors->has('password'))
                    <p class="help-block">
                        {{ $errors->first('password') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.password_helper') }}
                </p>
            </div>
           
            <div class="{{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                <label for="profile_pic">Profile Photo*</label>
                <input type="file" id="profile_pic" name="profile_pic" class="form-control" value="" {{ isset($profile->profile_pic) ? '' : 'required' }}>
                @if($errors->has('profile_pic'))
                    <p class="help-block">
                        {{ $errors->first('profile_pic') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.advertisement.fields.title_helper') }}
                </p>
                @if(isset($profile->profile_pic)) 
                    <img src="{{ url('images/banners/'.$profile->profile_pic)}}" width="220">
                @endif
                <input type="hidden" name="profile_pic_old" value="{{ isset($profile->profile_pic) ? $profile->profile_pic : '' }}">
            </div>

            <div class="{{ $errors->has('banner_pic') ? 'has-error' : '' }}">
                <label for="profile_pic">Featured Image*</label>
                <input type="file" id="profile_pic" name="banner_pic" class="form-control" value="" {{ isset($profile->profile_pic) ? '' : 'required' }}>
                @if($errors->has('banner_pic'))
                    <p class="help-block">
                        {{ $errors->first('banner_pic') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.advertisement.fields.title_helper') }}
                </p>
                @if(isset($profile->profile_pic)) 
                    <img src="{{ url('images/banners/'.$profile->banner_pic)}}" width="220">
                @endif
                <input type="hidden" name="profile_pic_old" value="{{ isset($profile->banner_pic) ? $profile->profile_pic : '' }}">
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
