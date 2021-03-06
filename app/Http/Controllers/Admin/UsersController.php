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

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->whereHas("roles", function($q){ 
                            $q->where('title', '=', 'User');
                        })
                ->leftJoin('user_subscription','user_subscription.user_id', '=', 'users.id')
                ->select('users.*', 'user_subscription.title as plan')
                ->get();

        $data['title'] = 'Users';
        $data['users'] = $users;

        return view('admin.users.index', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $data['title'] = 'Add User';
        $data['roles'] = $roles;
        return view('admin.users.create', $data);
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

        return redirect()->route('admin.users.index');

    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $roles = Role::all()->pluck('title', 'id');

        // $user->load('roles');

        // return view('admin.users.edit', compact('roles', 'user'));

        $roles = Role::all()->pluck('title', 'id');
        // $subscriptions = Subscription::all();
        $user->load('roles');

        // $subscription = UserSubscription::where('user_id',$user->id)->first();
        // $subscription_id = '';

        // if(!empty($subscription)) {
        //     $subscription_id = $subscription->subscription_id;
        // }
        $data['title'] = 'Edit User';
        // $data['subscriptions'] = $subscriptions;
        $data['roles'] = $roles;
        // $data['subscription_id'] = $subscription_id;
        $data['user'] = $user;
        $data['user_meta'] = Helper::getUserMeta($user->id);

        return view('admin.users.edit', $data);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // $user->update($request->all());
        // $user->roles()->sync($request->input('roles', []));

        // return redirect()->route('admin.users.index');


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
            $fileName = $request->profile_pic_old;
        }

        // Helper::update_user_meta($user->id, 'profile_pic', $fileName);
        $user->profile_pic = $fileName;
        $user->save();

        return redirect()->route('admin.users.index');

    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        $data['title'] = 'User';
        $data['user'] = $user;
        return view('admin.users.show', $data);
    }

    public function isenable($id){

        $user = User::where('id','=',$id)->first();

        User::where('id','=',$id)->update([
            'is_enable' => ($user->is_enable == 1) ? 0 : 1
        ]);

        return redirect()->back()->with('success', 'Updated!');   

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
