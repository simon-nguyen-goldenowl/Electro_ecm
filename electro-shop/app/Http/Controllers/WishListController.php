<?php

namespace App\Http\Controllers;

use App\Enums\ResultType;
use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    protected $wishlistService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }
    public function addWishlist($id)
    {
        $message = '';
        $data = $this->wishlistService->addWishlist($id);
        if ($data == ResultType::Failure) {
            $message = 'This product is already in your wishlist';
        } else {
            $message = 'this product is added to your wishlist';
        }
        return $message;
    }
    public function deleteWishlist($id)
    {
        $data = $this->wishlistService->deleteItem($id);
        return back();
    }
}
