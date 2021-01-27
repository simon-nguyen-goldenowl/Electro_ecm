<?php

namespace App\Services;

use App\Enums\ESIndexType;
use App\Enums\ESStatusType;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewService extends CommonService
{

    public function getModel()
    {
        return Review::class;
    }
    private function filterColumn(Request $request)
    {
        $result = Review::with('customer')->product($request);
        return $result;
    }
    public function getAllReviews(Request $request)
    {
        $query = $this->filterColumn($request);
        $result = $this->getAll($query, $request);
        return $result;
    }
    public function create($request)
    {
        $review = parent::create($request);
        $product = Product::find($request['product_id']);
        $product->es_status = ESStatusType::IsUpdated;
        $product->save();
    }

    public function deleteReviews($product_id)
    {
        Review::where('product_id', $product_id)->delete();
    }
}
