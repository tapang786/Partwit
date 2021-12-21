@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{$title}}
        </h4>
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Seller {{ trans('cruds.user.fields.id') }}</th>
                        <td>#{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Seller {{ trans('cruds.user.fields.name') }}</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Seller {{ trans('cruds.user.fields.email') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Profile Image</th>
                        <td>
                            @if(isset($user->profile_pic)) 
                                <img src="{{ url($user->profile_pic)}}" width="220">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            Roles
                        </th>
                        <td>
                            @foreach($user->roles as $id => $roles)
                                <span class="label label-info label-many">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
