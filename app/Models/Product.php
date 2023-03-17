<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['shop_name', 'category_name', 'service_name'];

    public function scopeSearch($query, $filter)
    {
    	$searchQuery = trim($filter);
    	$requestData = ['name'];
    	$query->when($filter!='', function ($query) use($requestData, $searchQuery) {
    		return $query->where(function($q) use($requestData, $searchQuery) {
    			foreach ($requestData as $field)
    				$q->orWhere($field, 'like', "%{$searchQuery}%");
    			});
    	});
    }

    public function getCategoryNameAttribute()
    {
        $category = Category::where('id', $this->category_id)->first();
        return $category->name;
    }

     public function getServiceNameAttribute()
    {
        $service = Service::where('id', $this->service_id)->first();
        return $service->name;
    }

     public function getShopNameAttribute()
    {
        $vendor = Vendor::where('id', $this->shop_id)->first();
        return $vendor->shop_name;
    }
}
