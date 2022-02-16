<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\PlanPayments;
use App\Product;
use App\Reports;

class HomeController
{
    public function index()
    {   
        $data['title'] = 'Dashboard';

        $data['users'] = User::all()->count();
        $data['revenue'] = PlanPayments::all()->sum('amount');
        $data['total_products'] = Product::all()->count();
        $data['reports'] = Reports::all()->count();

        $data['plan_payments'] = PlanPayments::with('user', 'subscription')->latest()->limit('5')->get();
        $data['products'] = Product::latest()->limit('5')->get();
        
        return view('home', $data);
    }

    
}
