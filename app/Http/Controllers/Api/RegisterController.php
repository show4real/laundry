<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Validator;

class RegisterController extends Controller
{
    public function vendorRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',∑
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
       
        $user= new User();
        $user->admin=0;
        $user->vendor=1;
        $user->customer=0;
        $user->is_active =1;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        $vendor = new Vendor();
        if($request->vendor == 1){
            $vendor->user_id = $vendor->id;
            $vendor->save();
        }
        return response()->json(compact('vendor'));
    }
}
