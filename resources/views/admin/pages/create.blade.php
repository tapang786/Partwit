@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.create') }} Page
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.pages.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ __('Title') }} *</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($page) ? $page->title : '') }}" required>
                @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                @endif
                
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ __('Description') }}</label>
                {{-- <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($page) ? $page->description : '') }}"> --}}
                <textarea name="description" name="description" >{{ old('description', isset($page) ? $page->description : '') }}</textarea>
                @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">{{ __('Status') }}*</label>
                        @php $status = (isset($page->status) ? $page->status : ''); @endphp
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="publish" {{ ($status == 'publish') ? 'selected' : '' }}>Publish</option>
                            <option value="draft" {{ ($status == 'draft') ? 'selected' : '' }}>Draft</option>
                            <option value="pending" {{ ($status == 'pending') ? 'selected' : '' }}>Pending</option>
                        </select>
                        
                        @if($errors->has('status'))
                            <p class="help-block">
                                {{ $errors->first('status') }}
                            </p>
                        @endif                        
                    </div>
                </div>
            </div>
                        
            <div>
                <input type="hidden" value="{{ isset($page->id)? $page->id: ''}}" name="id">
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
