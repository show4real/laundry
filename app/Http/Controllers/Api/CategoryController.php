<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Validator;
use Str;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::search($request->search)
           ->paginate($request->rows, ['*'], 'page', $request->page);
        return response()->json(compact('categories'));
    }

    public function show(Category $category){

        return response()->json(compact('category'));
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
        
            'name' => 'required|unique:categories'
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
        $category= new Category();
        $category->name = $request->name;
        $category->slug =Str::slug($request->name);
        $category->save();
        return response()->json(compact('category'));
    }


    public function update(Request $request, Category $category){

        $validator = Validator::make($request->all(), [
            'name' => 'unique:categories,name,'. $category->id
        ]);

        if($validator->fails()){
          return response()->json($validator->messages(), 422);
        }
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();
        return response()->json(compact('category'));
    }

     public function delete($id, Request $request){
        $category = Category::where('id', $id)->first();
        $category->delete();
        $category_id = Category::first()->id;
        Product::where('category_id', '=', $category->id)->update(['category_id' => $category_id]);
        return response()->json(true);
    }
}
