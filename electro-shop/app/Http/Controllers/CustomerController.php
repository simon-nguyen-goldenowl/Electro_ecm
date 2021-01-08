<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ReviewService;
use App\Services\UserService;
use App\Services\WishlistService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class CustomerController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $brandService;
    protected $reviewService;
    protected $cartService;
    protected $wishlistService;
    protected $userService;
    protected $orderService;
    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        BrandService $brandService,
        ReviewService $reviewService,
        CartService $cartService,
        WishlistService $wishlistService,
        UserService $userService,
        OrderService $orderService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->reviewService = $reviewService;
        $this->cartService = $cartService;
        $this->wishlistService = $wishlistService;
        $this->userService = $userService;
        $this->orderService = $orderService;
    }
    //COMMON FUNCTIONS
    public function getListProduct(Request $request)
    {
        return $this->productService->getAllProducts($request);
    }
    public function getDetailProduct($id)
    {
        return $this->productService->getById($id);
    }
    public function getListCategory(Request $request)
    {
        return $this->categoryService->getAllCategories($request);
    }

    public function getListBrand(Request $request)
    {
        return $this->brandService->getAllBrands($request);
    }

    protected function getNewProduct(Request $request)
    {
        $request['newest'] = null;
        return $this->productService->getAllProducts($request);
    }

    protected function getTopSellingProduct(Request $request)
    {
        $request['top_selling'] = null;
        return $this->productService->getAllProducts($request);
    }
    protected function getRelatedReview(Request $request, $id)
    {
        $request['product_id'] = $id;
        $request['limit'] = 3;
        return $this->reviewService->getAllReviews($request);
    }
    protected function getRelatedProduct(Request $request, $id)
    {
        return $this->productService->getRelatedProduct($request, $id);
    }
    protected function addCart(Request $request)
    {
        $this->cartService->addCart($request);
    }
    //FUNCTION TO DISPLAY INDEX PAGE
    public function displayIndexPage(Request $request)
    {
        $cate = $this->getListCategory($request);
        $new = $this->getNewProduct($request);
        unset($request['newest']); //to get the correct top-selling list (no depend on newest)
        $top = $this->getTopSellingProduct($request);
        return view('Pages.Index')->with([
            'categories' => $cate,
            'new_products' => $new,
            'top_products' => $top,
        ]);
    }
    //FUNCTION TO DISPLAY STORE PAGE
    public function displayStorePage(Request $request)
    {
        if (!isset($request['cate_id'])) {
            return redirect('/products?cate_id=1');
        }
        $cate = $this->getListCategory($request);
        $brand = $this->getListBrand($request);
        $product = $this->getListProduct($request);

        unset($request['brand_id']); //to get the correct top-selling list (no depend on brand)
        $top = $this->getTopSellingProduct($request);
        return view('Pages.Store')->with([
           'brands' => $brand,
           'categories' => $cate,
           'top_products' => $top,
           'products' => $product,
        ]);
    }
    //FUNCTION TO DISPLAY PRODUCT_LIST COMPONENT IN STORE PAGE
    public function displayProductListComponent(Request $request)
    {
        if (!isset($request['limit'])) {
            $request['limit'] = 15; //set default value for pagination
        }
        $product = $this->getListProduct($request);
        return view('Components.ProductList')->with([
           'products' => $product,
        ]);
    }

    //FUNCTION TO DISPLAY PRODUCT PAGE
    public function displayProductPage(Request $request, $id)
    {
        $detail = $this->getDetailProduct($id);
        if ($detail === null) {
            abort(404);
        }
        $review = $this->getRelatedReview($request, $id);
        $related = $this->getRelatedProduct($request, $id);

        return view('Pages.Product')->with([
            'related' => $related,
            'detail' => $detail,
            'reviews' => $review
        ]);
    }
    //FUNCTION TO DISPLAY REVIEW_LIST COMPONENT IN PRODUCT PAGE
    public function displayReviewListComponent(Request $request, $id)
    {
        $review = $this->getRelatedReview($request, $id);
        return view('Components.Review')->with([
            'reviews' => $review,
            'id' => $id
        ]);
    }
    //FUNCTION TO DISPLAY CHECKOUT PAGE
    public function displayCheckoutPage()
    {
        $user = [];
        if (session()->has('user')) {
            $user = $this->userService->getById(session()->get('user'));
        }
        $this->cartService->checkCart();
        return view('Pages.Checkout')->with([
            'status' => 0,
            'user' => $user
        ]);
    }

    //FUNCTION TO DISPLAY CART PAGE
    public function displayCartPage()
    {
        $this->cartService->checkCart();
        return view('Pages.Cart');
    }
    //FUNCTION TO DISPLAY REGISTER PAGE
    public function displayRegisterPage()
    {
        return view('Pages.Register');
    }
    //FUNCTION TO DISPLAY WISHLIST PAGE
    public function displayWishlistPage()
    {
        $data = $this->wishlistService->showWishlist();
        return view('Pages.Wishlist')->with('items', $data);
    }
    //FUNCTION TO DISPLAY PROFILE PAGE
    public function displayProfilePage()
    {
        if (session()->has('user')) {
            $user = $this->userService->getById(session()->get('user'));
            return view('Pages.Profile')->with('user', $user);
        } else {
            return back();
        }
    }
    //FUNCTION TO DISPLAY CHANGE PASSWORD PAGE
    public function displayChangePasswordPage()
    {
        if (session()->has('user')) {
            return view('Pages.ChangePassword');
        } else {
            return back();
        }
    }
    //FUNCTION TO DISPLAY ORDER PAGE
    public function displayOrderPage()
    {
        if (session()->has('user')) {
            $order = $this->orderService->showOrder();
            return view('Pages.Order')->with('orders', $order);
        } else {
            return back();
        }
    }
    //FUNCTION TO DISPLAY ORDER_DETAIL PAGE
    public function displayOrderDetailPage($id)
    {
        $total = 0;
        $order = $this->orderService->getById($id);
        $detail = $this->orderService->showOrderDetail($id);
        //calculate total price
        foreach ($detail as $de) {
            $total = $total + $de->total;
        }
        return view('Pages.OrderDetail')->with([
            'order' => $order,
            'details' => $detail,
            'total' => $total
        ]);
    }
    //FUNCTION TO DISPLAY FORGOT PASSWORD PAGE
    public function displayForgotPasswordPage()
    {
        return view('Pages.ForgotPassword');
    }
    //FUNCTION TO DISPLAY RESET PASSWORD PAGE
    public function displayResetPasswordPage($id)
    {
        if (!session()->has('reset_time')) {
            abort(419);
        } elseif (Carbon::now()->subMinutes('15')->gt(session()->get('reset_time'))) {
            abort(419);
        }
        return view('Pages.ResetPassword')->with('id', $id);
    }
}
