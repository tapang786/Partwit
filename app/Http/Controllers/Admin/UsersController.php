<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Subscription;
use App\UserSubscription;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                        ->where('role_user.role_id', '=', '2')
                        ->leftJoin('user_subscription','user_subscription.user_id','=','users.id')
                        ->select('users.*', 'user_subscription.title')
                        ->get();

        $subscriptions = Subscription::all();

        $data['title'] = 'All Users';
        $data['subscriptions'] = $subscriptions;
        $data['users'] = $users;

        return view('admin.users.index', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $subscriptions = Subscription::all();
        $roles = Role::all()->pluck('title', 'id');

        $data['title'] = 'Add User';
        $data['subscriptions'] = $subscriptions;
        $data['roles'] = $roles;

        return view('admin.users.create', $data);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        \Helper::updateUserSubscriptionPlan($user->id, $request->subscribe);

        if(isset($request->profile_pic)) {
            $fileName = time().'_'.$user->id.'_'.$request->profile_pic->getClientOriginalName();
            $request->profile_pic->move(base_path('images'), $fileName);

            \Helper::update_user_meta($user->id, 'profile_pic', 'images/'.$fileName);
        }

        return redirect()->route('admin.users.index');

    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        $subscriptions = Subscription::all();
        $user->load('roles');

        $subscription = UserSubscription::where('user_id',$user->id)->first();
        $subscription_id = '';

        if(!empty($subscription)) {
            $subscription_id = $subscription->subscription_id;
        }
        $data['title'] = 'Edit User';
        $data['subscriptions'] = $subscriptions;
        $data['roles'] = $roles;
        $data['subscription_id'] = $subscription_id;
        $data['user'] = $user;
        $data['user_meta'] = \Helper::getUserMeta($user->id);

        return view('admin.users.edit', $data);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        \Helper::updateUserSubscriptionPlan($user->id, $request->subscribe);

        if(isset($request->profile_pic)) {
            $fileName = time().'_'.$user->id.'_'.$request->profile_pic->getClientOriginalName();
            $request->profile_pic->move(base_path('images'), $fileName);

            if(file_exists(base_path('images/'.$request->profile_pic_old)) && isset($request->profile_pic_old)) { 
                unlink(base_path('images/'.$request->profile_pic_old));
            }

            $fileName = 'images/'.$fileName;

        } else {
            $fileName = $request->profile_pic_old;
        }

        \Helper::update_user_meta($user->id, 'profile_pic', $fileName);

        return redirect()->route('admin.users.index');

    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        $data['title'] = 'View User';
        $data['user'] = $user;
        $data['user_meta'] = \Helper::getUserMeta($user->id);
        $data['subscription'] = UserSubscription::where('user_id',$user->id)->first();

        return view('admin.users.show', $data);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();

    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
