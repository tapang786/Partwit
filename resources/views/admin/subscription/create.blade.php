@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.create') }} {{ trans('cruds.subscription.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.subscription.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.subscription.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($subscription) ? $subscription->title : '') }}" required>
                @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.subscription.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label for="price">{{ trans('cruds.subscription.fields.price') }}*</label>
                <?php $subscription_types = ['free' => 'Free', 'featured' => 'Featured', 'premium' => 'Premium']; ?>
                <select name="subscription_type" class="form-control" required placeholder="Subscription Type">
                    <option>Select Type</option>
                    @foreach($subscription_types as $k => $v)
                        <option value="{{$k}}" {{ isset($subscription) ? ($subscription->subscription_type == $k)?'selected':'' : '' }}>{{$v}}</option>
                    @endforeach
                </select>
                <p class="helper-block">
                    {{ trans('cruds.subscription.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label for="price">{{ trans('cruds.subscription.fields.price') }}*</label>
                <input type="text" id="price" name="price" class="form-control" value="{{ old('price', isset($subscription) ? $subscription->price : '') }}">
                @if($errors->has('price'))
                    <p class="help-block">
                        {{ $errors->first('price') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.subscription.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                <label for="type">Time Duration*</label>
                <div class="row">
                    <div class="col-6 col-md-6">
                        <?php $types = ['day' => 'Days', 'month' => 'Month', 'year' => 'Year']; ?>
                        <select name="type" class="form-control" required placeholder="Duration Type">
                            @foreach($types as $k => $v)
                                <option value="{{$k}}" {{ isset($subscription) ? ($subscription->type == $k)?'selected':'' : '' }}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-6">
                        <input type="number" name="number" value="{{ old('number', isset($subscription) ? $subscription->number : '') }}" placeholder="Duration Number" class="form-control" min="0" max="100" required>
                    </div>
                </div>
                <!-- <input type="text" id="type" name="type" class="form-control" value="{{ old('type', isset($subscription) ? $subscription->type : '') }}"> -->
                
                <!-- <p class="helper-block">
                    {{ trans('cruds.subscription.fields.title_helper') }}
                </p> -->
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.subscription.fields.description') }}</label>
                <textarea name="description" name="description" >{{ old('description', isset($subscription) ? $subscription->description : '') }}</textarea>
                <!-- <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($subscription) ? $subscription->description : '') }}"> -->
                @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.subscription.fields.title_helper') }}
                </p>
            </div>

            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('start_at') ? 'has-error' : '' }}">
                        <label for="start_at">{{ trans('cruds.subscription.fields.start_at') }}*</label>
                        @php $start_at = isset($subscription) ? \Carbon\Carbon::parse($subscription->start_at)->format('Y-m-d') : '' ; @endphp
                        <input type="date" id="start_at" name="start_at" class="form-control" value="{{ old('start_at', $start_at) }}" required>
                        @if($errors->has('start_at'))
                            <p class="help-block">
                                {{ $errors->first('start_at') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.subscription.fields.title_helper') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('end_at') ? 'has-error' : '' }}">
                        <label for="end_at">{{ trans('cruds.subscription.fields.end_at') }}*</label>
                        @php $end_at = isset($subscription) ? \Carbon\Carbon::parse($subscription->end_at)->format('Y-m-d') : '' ; @endphp
                        <input type="date" id="end_at" name="end_at" class="form-control" value="{{ old('end_at', $end_at) }}" required>
                        @if($errors->has('end_at'))
                            <p class="help-block">
                                {{ $errors->first('end_at') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.subscription.fields.title_helper') }}
                        </p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('banner_image') ? 'has-error' : '' }}">
                        <label for="banner_image">{{ trans('cruds.subscription.fields.banner_image') }}*</label>
                        <input type="file" id="banner_image" name="banner_image" class="form-control" value="" {{ isset($subscription->banner_image) ? '' : 'required' }}>
                        @if($errors->has('banner_image'))
                            <p class="help-block">
                                {{ $errors->first('banner_image') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.subscription.fields.title_helper') }}
                        </p>
                        @if(isset($subscription->banner_image)) 
                            <img src="{{ url('images/banners/'.$subscription->banner_image)}}" width="220">
                        @endif
                        <input type="hidden" name="banner_image_old" value="{{ isset($subscription->banner_image) ? $subscription->banner_image : '' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">{{ trans('cruds.subscription.fields.status') }}*</label>
                        @php $status = (isset($subscription->status) ? $subscription->status : ''); @endphp
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
                            {{ trans('cruds.subscription.fields.title_helper') }}
                        </p>
                        
                    </div>
                </div>
            </div> -->
                        

            <div>
                <input type="hidden" value="{{ isset($subscription->id)? $subscription->id: ''}}" name="id">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // CKEDITOR.replace( 'description' );

    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>


@endsection
