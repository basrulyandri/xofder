<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    	return view('dashboard');
    }

    public function toggleBlockApp($toggle)
    {
    	$block = \App\Setting::whereSettingKey('kasir_is_blocked')->first();
    	if($toggle == 'open'){
    		$block->setting_value = '0';
    	}

    	if($toggle == 'close'){
    		$block->setting_value = '1';
    	}

    	$block->save();

    	return redirect()->back()->with('success','Sukses');
    }
}
