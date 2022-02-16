@extends('layouts.admin')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ $title }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.products.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($product) ? $product->name : '') }}" required>
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
                {{-- <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($product) ? $product->description : '') }}"> --}}
                <textarea name="description" name="description" >{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.advertisement.fields.title_helper') }}
                </p>
            </div>
            <br>
            <div class="form-group {{ $errors->has('short_desc') ? 'has-error' : '' }}">
                <label for="short_desc">Short Description</label>
                <input type="text" id="short_desc" name="short_desc" class="form-control" value="{{ old('short_desc', isset($product) ? $product->short_desc : '') }}">
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('seller') ? 'has-error' : '' }}">
                        <label for="sellername">Seller Name*</label>
                        <input type="text" class="form-control" disabled value="{{$product->seller->name}}">
                        <input type="hidden" name="seller_id" value="{{$product->seller_id}}">
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                        <label for="price">Price*</label>
                        
                        <input type="text" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        @if($errors->has('price'))
                            <p class="help-block">
                                {{ $errors->first('price') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('listed_on') ? 'has-error' : '' }}">
                        <label for="listed_on">Listed On*</label>
                        @php $listed_on = isset($product) ? \Carbon\Carbon::parse($product->listed_on)->format('Y-m-d') : '' ; @endphp
                        <input type="date" id="listed_on" name="listed_on" class="form-control" value="{{ old('listed_on', $listed_on) }}" required>
                        @if($errors->has('listed_on'))
                            <p class="help-block">
                                {{ $errors->first('listed_on') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('expires_on') ? 'has-error' : '' }}">
                        <label for="expires_on">Expires On*</label>
                        @php $expires_on = isset($product) ? \Carbon\Carbon::parse($product->expires_on)->format('Y-m-d') : '' ; @endphp
                        <input type="date" id="expires_on" name="expires_on" class="form-control" value="{{ old('expires_on', $expires_on) }}" required>
                        @if($errors->has('expires_on'))
                            <p class="help-block">
                                {{ $errors->first('expires_on') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                <label for="category">Category*</label>
                <select id="category" name="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $k => $cat)
                    <option value="{{$cat->id}}" @if(isset($product->category_id) && $product->category_id == $cat->id) selected @endif>{{$cat->title}}</option>
                    @endforeach
                </select>
            </div>
            <br>
            
            <div class="form-group {{ $errors->has('attribute') ? 'has-error' : '' }}" style="display: {{isset($product->attributes)?'block':'block' }};">
                <label for="attribute">Attributes*</label>
                <select class="js-example-basic-multiple form-control attributes" name="product_attributes[]" multiple="multiple">
                @foreach($attributes as $k => $attribute)
                    <option value="{{$attribute->id}}" {{ (array_key_exists("attr_".$attribute->id,$product_attributes))?'selected':''}}>{{$attribute->title}}</option>
                @endforeach
                </select>
                <button type="button" class="btn btn-sm btn-primary" id="select_values">Select Values</button>
                <div class="row attribute_list">

                @if(count($product_attributes) > 0)
                    @foreach($attributes as $k => $attribute)
                        @if(array_key_exists("attr_".$attribute->id,$product_attributes))
                        <div class="col-md-4" id="{{$attribute->id}}">
                            {{-- <span class="remove_attribute" attr-id="{{$attribute->id}}"><i class="far fa-times-circle"></i></span> --}}
                            <div class="form-group">
                                <label for="{{$attribute->title}}">{{$attribute->title}}</label>
                                <select class="form-control attributes {{$attribute->title}}" name="attributes_value[{{$attribute->id}}][]">
                                <option value="">Select Value</option>';
                                @foreach($attribute->values as $k => $value) 
                                    <option value="{{$value->id}}" {{($value->id == $product_attributes['attr_'.$attribute->id]['attribute_value_id'])?'selected':''}}>{{$value->title}}</option>
                                @endforeach
                                </select>
                                
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('featured_image') ? 'has-error' : '' }}">
                        <label for="featured_image">Images*</label>
                        <input type="file" id="featured_image" name="featured_image[]" class="form-control" value="" {{ isset($product->featured_image) ? '' : 'required' }} style="opacity: 1; position: relative; z-index: 999;" multiple>
                        @if($errors->has('featured_image'))
                            <p class="help-block">
                                {{ $errors->first('featured_image') }}
                            </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.advertisement.fields.title_helper') }}
                        </p>
                        {{-- @if(isset($product->featured_image)) 
                            <img src="{{ url($product->featured_image)}}" width="220">
                        @endif --}}

                        <input type="hidden" name="featured_image_old" value="{{ isset($product->featured_image) ? $product->featured_image : '' }}">


                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">{{ trans('cruds.advertisement.fields.status') }}*</label>
                        @php $status = (isset($product->status) ? $product->status : ''); @endphp
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="1" {{ ($product->status == 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ ($product->status == 0) ? 'selected' : '' }}>In active</option>
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
            <div class="row">
                <div class="col-md-12 gallery_images">
                    @if($product->all_images)
                        @foreach(json_decode($product->all_images) as $img_key => $img)
                            <img src="{{ url($img)}}">
                        @endforeach
                        {{-- @foreach(json_decode($product->all_images) as $img_key => $img)
                            <img src="{{ url($img)}}">
                        @endforeach --}}
                    @endif
                </div>
            </div>

             

            <div>
                <input type="hidden" value="{{ isset($product->id)? $product->id: ''}}" name="pro_id">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

<style type="text/css">
    .select2-container .select2-selection--multiple {
        min-height: 38px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding-right: 5px;
        margin-right: 0px;
        background: #ff9800d9;
    }
    .remove_attribute {
        float: right;
        position: absolute;
        right: 15px;
        top: 10px;
        cursor: pointer;
        z-index: 9999;
    }

    .gallery_images > img {
        border: 1px solid;
        height: 100px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script>
    // var attributes_data = jQuery.parseJSON( '');
    // CKEDITOR.replace( 'description' );
    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    $(document).ready(function() {

        $(document).on("click",".remove_attribute", function(){
            // alert('a')
            $('#'+$(this).attr('attr-id')).remove();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".js-example-basic-multiple").on("select2:select", function (e) { 
            var select_val = $(e.currentTarget);
            console.log(select_val)
        });
   
        $("#select_values").click(function(e){
      
            e.preventDefault();
            var attributes = $(".attributes").val();
            // alert(attributes)
       
            $.ajax({
                type:'POST',
                url:"{{ route('admin.get-attribures-values') }}",
                data:{attribute_list:attributes},
                success:function(response){

                    // alert(data.success);
                    if(response.status){
                        $('.attribute_list').html(response.html);
                    }

               }
            });
      
        });
        
        $('.js-example-basic-multiple').select2();

        $(document).on('change', '#category', function(e){
            // 
            e.preventDefault();
       
            var category = $(this).val();
       
            $.ajax({
                type:'POST',
                url:"{{ route('admin.get-attribures') }}",
                data:{category:category},
                success:function(response){
                    // 
                    console.log(response)
                    if(response.status) {
                        $(".attributes").html(response.html);
                        $('.js-example-basic-multiple').select2("destroy").select2();
                    }
               }
            });
        });
    });
    
</script>
@endsection
