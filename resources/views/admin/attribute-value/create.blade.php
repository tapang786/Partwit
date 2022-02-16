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
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group " style="    margin: -10px;">
                        <label for="attribute">Type *</label>
                        <select class="form-control" name="type" id="attribute">
                            <option value="">Select Type</option>
                            <option value="text" {{(isset($attributeValue) && $attributeValue->type == 'text')?'selected':''}}>Text</option>
                            <option value="color" {{(isset($attributeValue) && $attributeValue->type == 'color')?'selected':''}}>Color</option> 
                        </select>
                    </div>
                </div>
                <div class="col-md-6 color" >
                    <div class="form-group">
                        <label for="color">Color Code*</label>
                        <input type="color" id="color" class="form-control" value="{{isset($attributeValue->color) ? $attributeValue->color : ''}}" name="color" style="height: 55px;">
                    </div>
                </div>
            </div>
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

@section('scripts')
<style type="text/css">
    .color {
        display: {{isset($attributeValue->color) ? 'block' : 'none'}};
    }
</style>
<script>
    $(document).ready(function() {

        $(document).on('change', '#attribute', function(e){
            // 
            e.preventDefault();
       
            var category = $(this).val();
       
            if(category == 'text') {
                $('.color').hide();
            } else {
                $('.color').show();
            }
        });
    });
    
</script>
@endsection

