<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ApiController extends Controller
{
    public function updatenewimageforproduct(Request $request)
    {    	
    	//dd($request->all());
    	if($request->oldImageName){
    		\File::delete(public_path('/uploads/produk/'.$request->oldImageName));
    	}
    	if(!Image::make($request->image)->resize(500,null,function($constrain){
            $constrain->aspectRatio();
        }
        )->save(public_path('/uploads/produk/'.$request->filename))){
          return response()->json(['status' => 401]);
        }
		return response()->json($request->all());
    }
}
