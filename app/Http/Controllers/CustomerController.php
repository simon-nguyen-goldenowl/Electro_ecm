<?php

namespace App\Http\Controllers;

use App\Enums\DefaultType;
use App\Models\Product;
use App\Services\BrandService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ReviewService;
use App\Services\SearchService;
use App\Services\UserService;
use App\Services\WishlistService;
use Carbon\Carbon;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class CustomerController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $brandService;
    protected $reviewService;
    protected $searchService;
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
        OrderService $orderService,
        SearchService $searchService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->reviewService = $reviewService;
        $this->cartService = $cartService;
        $this->wishlistService = $wishlistService;
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->searchService = $searchService;
    }

    //COMMON FUNCTIONS
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

    //FUNCTION TO DISPLAY INDEX PAGE
    public function displayIndexPage(Request $request)
    {
        $new = $this->getNewProduct($request);
        unset($request['newest']); //to get the correct top-selling list (no depend on newest)
        $top = $this->getTopSellingProduct($request);
        return view('Pages.Index')->with([
            'new_products' => $new,
            'top_products' => $top,
        ]);
    }

    //FUNCTION TO DISPLAY STORE PAGE
    public function displayStorePage(Request $request)
    {
        $brand = $this->brandService->getAllBrands($request);
        $product = $this->productService->getAllProducts($request);
        unset($request['brand_id']); //to get the correct top-selling list (no depend on brand)
        $top = $this->getTopSellingProduct($request);
        return view('Pages.Store')->with([
           'brands' => $brand,
           'top_products' => $top,
           'products' => $product,
        ]);
    }

    public function test()
    {
        $client = ClientBuilder::create()->build();
        $products = Product::where('is_sync_es', 0)->take(15)->get();
        foreach ($products as $product) {
            $params = [
                'index' => 'products',
                'id'    => $product->id,
                'body'  => [
                    'name' => $product->name,
                    'price' => $product->price,
                    'cate_id' => $product->cate_id,
                    'brand_id' => $product->brand_id,
                    'cate_name' => $product->category->name,
                    'brand_name' => $product->brand->name
                ]
            ];
            $client->index($params);
            $product->is_sync_es = 1;
            $product->save();
        }
    }
    //FUNCTION TO DISPLAY PRODUCT_LIST COMPONENT
    public function displayProductListComponent(Request $request)
    {
        if (!isset($request['limit'])) {
            $request['limit'] = DefaultType::default_limit; //set default value for pagination
        }
        $product = $this->productService->getAllProducts($request);
        return view('Components.ProductList')->with([
           'products' => $product,
        ]);
    }

    //FUNCTION TO DISPLAY PRODUCT PAGE
    public function displayProductPage(Request $request, $id)
    {
        $detail = $this->productService->getById($id);
        if ($detail === null) {
            abort(404);
        }
        $review = $this->getRelatedReview($request, $id);
        $related = $this->productService->getRelatedProduct($request, $id);

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

    //FUNCTION TO DISPLAY SEARCH PAGE
    public function displaySearchPage(Request $request)
    {
        $brand = $this->brandService->getAllBrands($request);
        $result = $this->searchService->getSearchProducts($request);
        $total = count($result);
        $product = $this->searchService->proccessSearchList($request, $result, $total);
        $paginate = $this->searchService->generatePaginate($request, $total);
        unset($request['brand_id']); //to get the correct top-selling list (no depend on brand)
        $top = $this->getTopSellingProduct($request);
        $key = null;
        if ($request['q'] !== null) {
            $key = $request['q'];
        }
        return view('Pages.Search')->with([
            'brands' => $brand,
            'top_products' => $top,
            'products' => $product,
            'paginate' => $paginate,
            'key' => $key,
            'total' => $total
        ]);
    }
    //FUNCTION TO DISPLAY LIST COMPONENT
    public function displaySearchListComponent(Request $request)
    {
        $result = $this->searchService->getSearchProducts($request);
        $total = count($result);
        $product = $this->searchService->proccessSearchList($request, $result, $total);
        $paginate = $this->searchService->generatePaginate($request, $total);
        return view('Components.SearchProductList')->with([
            'products' => $product,
            'paginate' => $paginate
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
