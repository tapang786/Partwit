@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
           
        </h4>
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Attribute Title
                        </th>
                        <td>
                            {{ $attr->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Attribute Value
                        </th>
                        <td>
                        @php $i = 1; @endphp 
                        @foreach($attrval as $val)
                            @php 
                                if($i==1) {
                                    echo trim($val->title);
                                } else {
                                    echo ', '.trim($val->title);
                                }
                                $i++;
                            @endphp
                        @endforeach
                        </td>
                    </tr>
                   
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
