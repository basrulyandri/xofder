<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function view(Customer $customer)
    {
    	if($customer->id == 1){
    		$orders = $customer->orders()->orderBy('created_at','desc')->paginate(10);    		
    	}else{
    		$orders = $customer->orders()->orderBy('created_at','desc')->get();    		
    	}    	
		$totalQty = $customer->orders->sum('total_qty');
		$totalPrice = $customer->orders->sum('total_price');
    	return view('customers.view',compact(['customer','orders','totalQty','totalPrice']));
    }
}
