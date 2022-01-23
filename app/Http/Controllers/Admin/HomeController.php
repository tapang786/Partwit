<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {   
        $data['title'] = 'Dashboard'; 

        $revenue = '';
        return view('home', $data);
    }
}
