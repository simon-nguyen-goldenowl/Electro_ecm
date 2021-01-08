<?php

namespace App\Services;

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
    public function deleteReviews($product_id)
    {
        Review::where('product_id', $product_id)->delete();
    }
}
