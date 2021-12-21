<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use App\Helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubAdminController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $sellers = User::all();
        $sellers = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                        ->where('role_user.role_id', '=', '3')
                        ->get();

        $data['title'] = 'Sub Admin';
        $data['sellers'] = $sellers;

        return view('admin.sub-admins.index', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('sub_admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $data['title'] = 'Add Sub Admin';
        $data['roles'] = $roles;

        return view('admin.sub-admins.create', $data);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        // Helper::updateUserSubscriptionPlan($user->id, $request->subscribe);

        if(isset($request->profile_pic)) {
            $fileName = time().'_'.$user->id.'_'.$request->profile_pic->getClientOriginalName();
            $request->profile_pic->move(base_path('images'), $fileName);

            // Helper::update_user_meta($user->id, 'profile_pic', 'images/'.$fileName);

            $user->profile_pic = 'images/'.$fileName;
            $user->save();
        }

        return redirect()->route('admin.sub-admins.index');

    }

    public function edit(User $user, $id)
    {
        abort_if(Gate::denies('sub_admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $roles = Role::all()->pluck('title', 'id');

        $user = User::where('id', $id)->first();

        // return view('admin.sub-admins.edit', compact('roles', 'user'));

        $roles = Role::all()->pluck('title', 'id');
        // $subscriptions = Subscription::all();
        $user->load('roles');

        // $subscription = UserSubscription::where('user_id',$user->id)->first();
        // $subscription_id = '';

        // if(!empty($subscription)) {
        //     $subscription_id = $subscription->subscription_id;
        // }
        $data['title'] = 'Edit Sub Admin';
        // $data['subscriptions'] = $subscriptions;
        $data['roles'] = $roles;
        // $data['subscription_id'] = $subscription_id;
        $data['user'] = $user;
        // dd($user);
        $data['user_meta'] = Helper::getUserMeta($user->id);

        return view('admin.sub-admins.edit', $data);
    }

    public function update(UpdateUserRequest $request, User $user, $id)
    {
        // $user->update($request->all());
        // $user->roles()->sync($request->input('roles', []));

        // return redirect()->route('admin.sub-admins.index');

        $user = User::where('id', $id)->first();
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        // Helper::updateUserSubscriptionPlan($user->id, $request->subscribe);

        if(isset($request->profile_pic)) {
            $fileName = time().'_'.$user->id.'_'.$request->profile_pic->getClientOriginalName();
            $request->profile_pic->move(base_path('images'), $fileName);

            if(file_exists(base_path('images/'.$request->profile_pic_old)) && isset($request->profile_pic_old)) { 
                unlink(base_path('images/'.$request->profile_pic_old));
            }

            $fileName = 'images/'.$fileName;

        } else {
            // 
            $fileName = $request->profile_pic_old;
        }

        // Helper::update_user_meta($user->id, 'profile_pic', $fileName);

        $user->profile_pic = $fileName;
        $user->save();

        return redirect()->route('admin.sub-admins.index');

    }

    public function show(User $user, $id)
    {
        abort_if(Gate::denies('sub_admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::where('id', $id)->first();
        $user->load('roles');

        $data['title'] = 'Show Sub Admin';
        $data['user'] = $user;
        $data['user_meta'] = Helper::getUserMeta($user->id);

        return view('admin.sub-admins.show', $data);
    }

    public function destroy(User $seller)
    {
        abort_if(Gate::denies('seller_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seller->delete();

        return back();

    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
