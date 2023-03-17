<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Product;
use Validator;
use Str;

class ServiceController extends Controller
{
    public function index(Request $request){
        $services = Service::search($request->search)
           ->paginate($request->rows, ['*'], 'page', $request->page);
        return response()->json(compact('services'));
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
        
            'name' => 'required|unique:services'
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
        $service= new Service();
        $service->name = $request->name;
        $service->slug =Str::slug($request->name);
        $service->save();
        return response()->json(compact('service'));
    }


    public function update(Request $request, Service $service){

        $validator = Validator::make($request->all(), [
            'name' => 'unique:services,name,'. $service->id
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->save();
        return response()->json(compact('service'));
    }

     public function delete($id, Request $request){
        $service = Service::where('id', $id)->first();
        $service->delete();
        $service_id = Service::first()->id;
        Product::where('service_id', '=', $service->id)->update(['service_id' => $service_id]);
        return response()->json(true);
    }

   
}
