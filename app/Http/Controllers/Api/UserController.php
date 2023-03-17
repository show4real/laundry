<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Validator;

class UserController extends Controller
{

    public function index(Request $request){
        $users = User::search($request->search)
        ->paginate($request->rows, ['*'], 'page', $request->page);
       
        return response()->json(compact('users'));
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users'
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
       
        $user= new User();
        $user->admin=$request->admin;
        $user->vendor=$request->vendor;
        $user->customer=$request->customer;
        $user->is_active =$request->is_active;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address=$request->address;
        $user->password=bcrypt($request->password);
        $user->save();
        $vendor = new Vendor();
        if($request->vendor == 1){
            $vendor->user_id = $user->id;
            $vendor->save();
        }
        return response()->json(compact('user'));
    }

    public function update(Request $request, User $user){

        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,'. $user->id
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
        $user->admin=$request->admin;
        $user->vendor=$request->vendor;
        $user->customer=$request->customer;
        $user->is_active = $request->is_active;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address=$request->address;
        $user->save();

        return response()->json(compact('user'));
    }


    public function show(User $user){

        return response()->json(compact('user'));
    }



     public function delete($id, Request $request){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(true);
    }
    
}
