<?php

namespace App\Services;

use App\Enums\ResultType;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistService extends CommonService
{
    public function getModel()
    {
        return Wishlist::class;
    }
    public function showWishlist()
    {
        $customer_id = session()->get('user');
        //find all products in this wishlist
        $data = Wishlist::with('product')
                        ->where('deleted_at', null)
                        ->where('customer_id', $customer_id)->get();
        return $data;
    }
    public function addWishlist($id)
    {
        //check whether product is stored in wishlist
        $product_count = Wishlist::query()
                                   ->where('product_id', $id)
                                   ->where('customer_id', session()
                                   ->get('user'))->count();
        if ($product_count > 0) {
            //if added fail
            return ResultType::Failure;
        }
        $request['customer_id'] = $customer_id = session()->get('user');
        $request['product_id'] = $id;
        $this->create($request);
        //if added success
        return ResultType::Success;
    }
    public function deleteWishlist($product_id)
    {
        Wishlist::where('product_id', $product_id)->delete();
    }
    public function deleteItem($id)
    {
        $customer_id = session()->get('user');
        $query = Wishlist::query();
        $data = $query->where('customer_id', $customer_id)
                      ->where('product_id', $id)
                      ->delete();
        return $data;
    }
}
