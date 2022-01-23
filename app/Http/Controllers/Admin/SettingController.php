<?php

namespace App\Http\Controllers\Admin;

use App\Setting;

class SettingController
{
    public function index()
    {   
        $data['title'] = 'Site Setting'; 
        return view('settings.setting', $data);
    }

    public function store(Request $request) {
        //
        try {
            Setting::updateOrCreate(['key' => $request->meta_key], [ 'value' => $request->meta_value ]);
        }
        catch(Exception $e) {
            echo $e;
        }
    }

    public function getUserMeta($key="")
    {
        if (empty($key)) {
            // 
            $userdetailsadd = Setting::where('meta_key', $key)->select('key', 'value')
                ->pluck('value', 'key')
                ->toArray();
            return $userdetailsadd;
        }
        else {
            //
            if ($status) {
                // 
                $userdetailsadd = Setting::where('meta_key', $key)->where('key', $key)->first();
                if (!empty($userdetailsadd))
                    return $userdetailsadd->value;
                else
                    return "";
            }
            else {
                $userdetailsadd = Setting::where('meta_key', $key)->where('key', $key)->select('key', 'value')
                    ->pluck('value', 'key')
                    ->toArray();
                return $userdetailsadd;
            }
        }
    }
}
