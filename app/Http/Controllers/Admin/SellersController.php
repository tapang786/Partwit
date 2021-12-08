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

class SellersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seller_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $sellers = User::all();
        $sellers = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                        ->where('role_user.role_id', '=', '3')
                        // ->leftJoin('user_subscription','user_subscription.user_id','=','users.id')
                        // ->select('users.*')
                        ->get();

        $data['title'] = 'Sellers';
        $data['sellers'] = $sellers;

        return view('admin.sellers.index', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('seller_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $data['title'] = 'Add Seller';
        $data['roles'] = $roles;

        return view('admin.sellers.create', $data);
    }

    public function store(StoreUserRequest $request)
    {
        $seller = User::create($request->all());
        $seller->roles()->sync($request->input('roles', []));

        // Helper::updateUserSubscriptionPlan($seller->id, $request->subscribe);

        if(isset($request->profile_pic)) {
            $fileName = time().'_'.$seller->id.'_'.$request->profile_pic->getClientOriginalName();
            $request->profile_pic->move(base_path('images'), $fileName);

            // Helper::update_user_meta($seller->id, 'profile_pic', 'images/'.$fileName);

            $seller->profile_pic = 'images/'.$fileName;
            $seller->save();
        }

        return redirect()->route('admin.sellers.index');

    }

    public function edit(User $seller)
    {
        abort_if(Gate::denies('seller_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $roles = Role::all()->pluck('title', 'id');

        // $seller->load('roles');

        // return view('admin.sellers.edit', compact('roles', 'user'));

        $roles = Role::all()->pluck('title', 'id');
        // $subscriptions = Subscription::all();
        $seller->load('roles');

        // $subscription = UserSubscription::where('user_id',$seller->id)->first();
        // $subscription_id = '';

        // if(!empty($subscription)) {
        //     $subscription_id = $subscription->subscription_id;
        // }
        $data['title'] = 'Edit Seller';
        // $data['subscriptions'] = $subscriptions;
        $data['roles'] = $roles;
        // $data['subscription_id'] = $subscription_id;
        $data['seller'] = $seller;
        $data['seller_meta'] = Helper::getUserMeta($seller->id);

        return view('admin.sellers.edit', $data);
    }

    public function update(UpdateUserRequest $request, User $seller)
    {
        // $seller->update($request->all());
        // $seller->roles()->sync($request->input('roles', []));

        // return redirect()->route('admin.sellers.index');


        $seller->update($request->all());
        $seller->roles()->sync($request->input('roles', []));

        // Helper::updateUserSubscriptionPlan($seller->id, $request->subscribe);

        if(isset($request->profile_pic)) {
            $fileName = time().'_'.$seller->id.'_'.$request->profile_pic->getClientOriginalName();
            $request->profile_pic->move(base_path('images'), $fileName);

            if(file_exists(base_path('images/'.$request->profile_pic_old)) && isset($request->profile_pic_old)) { 
                unlink(base_path('images/'.$request->profile_pic_old));
            }

            $fileName = 'images/'.$fileName;

        } else {
            // 
            $fileName = $request->profile_pic_old;
        }

        // Helper::update_user_meta($seller->id, 'profile_pic', $fileName);

        $seller->profile_pic = $fileName;
        $seller->save();

        return redirect()->route('admin.sellers.index');

    }

    public function show(User $seller)
    {
        abort_if(Gate::denies('seller_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seller->load('roles');

        $data['title'] = 'Show Seller';
        $data['seller'] = $seller;
        $data['seller_meta'] = Helper::getUserMeta($seller->id);

        return view('admin.sellers.show', $data);
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
