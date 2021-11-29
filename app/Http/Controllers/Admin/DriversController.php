<?php

namespace App\Http\Controllers\Admin;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = User::join('role_user', 'role_user.user_id', '=', 'users.id')->where('role_user.role_id', '=', '3')->get();

        $data['title'] = 'Drivers';
        $data['drivers'] = $drivers;
        return view('admin.drivers.index', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $data['title'] = 'Add Driver';
        $data['roles'] = $roles;
        return view('admin.drivers.create', $data);
    }

    public function store(StoreUserRequest $request)
    {
        $driver = User::create($request->all());
        $driver->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.drivers.index');

    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        $user = User::where('id', $id)->first();
        $user->load('roles');

        $data['title'] = 'Edit Driver';
        $data['user'] = $user;
        $data['roles'] = $roles;
        return view('admin.drivers.edit', $data);
    }

    public function update(Request $request, $id)
    {   
        $user = User::where('id', $id)->first();
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.drivers.index');

    }

    public function show($id)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::where('id', $id)->first();
        $user->load('roles');

        $data['title'] = 'View Driver';
        $data['user'] = $user;

        return view('admin.drivers.show', $data);
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::where('id', $id)->first();
        $user->delete();

        return back();

    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
