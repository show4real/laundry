<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Product;

class VendorProductController extends Controller
{
    public function index(Request $request){
        $vendor_id = Vendor::where('user_id', auth()->user()->id)->first()->id;
        $products = Product::where('vendor_id', $vendor_id)->search($request->search)
        ->paginate($request->rows, ['*'], 'page', $request->page);
       
        return response()->json(compact('products'));
    }

     private function extense($extension){
        $allowedfileExtension=['jpg','doc','docx','JPG','PNG','png','jpeg','jPG','pdf'];
       
        $check=in_array($extension,$allowedfileExtension);
        if($check){
            return true;
        }else{
           return false;
        }
    }

    private function uploadImage($file, $product_id){
        if($this->extense($extension)){
            $image_name = time().$file->getClientOriginalName();
            $path = 'vendors/'.$image_name;
            $url=url('/');
            
            $image = Product::where('id', $product_id);
            $image->image_type=$file->getClientOriginalExtension();
            
            $image->image_url = $url."/storage/".$path;
            $image->image_name = $file->getClientOriginalName();
            $image->save();
            $file->move(public_path('storage/vendors'), $image_name);

            } else {
            $errors="Invalid file type";
            return response()->json(compact('errors'), 422);
        }
    }

    public function save(Request $request){
        $vendor_id = Vendor::where('user_id', auth()->user()->id)->first()->id;

        $product= new Product();
        $product->service_id=$request->service_id;
        $product->cloth_name=$request->cloth_name;
        $product->category_id=$request->category_id;
        $product->image_url =$request->image_url;
        $product->image_type = $request->image_type;
        $product->image_name = $request->image_name;
        $product->status = $request->status;
        $product->vendor_id = $vendor_id;
        $product->save();
        if($request->file('image')){
            $image=$request->file('image');
            $this->uploadImage($image, $product->id);
            
        }
        return response()->json(compact('product'));
    }

    public function update(Request $request, Product $product){
        $vendor_id = Vendor::where('user_id', auth()->user()->id)->first()->id;
        $product->service_id=$request->service_id;
        $product->cloth_name=$request->cloth_name;
        $product->category_id=$request->category_id;
        $product->image_url =$request->image_url;
        $product->image_type = $request->image_type;
        $product->image_name = $request->image_name;
        $product->status = $request->status;
        $product->vendor_id = $vendor_id;
        $product->save();
        if($request->file('image')){
            $image=$request->file('image');
            $this->uploadImage($image, $product->id);
            
        }

        return response()->json(compact('vendor'));
    }

    public function show(Product $product){

        return response()->json(compact('product'));
    }
}
