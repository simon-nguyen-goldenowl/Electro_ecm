<?php

namespace App\Services;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryService extends CommonService
{
    public function getModel()
    {
        return Category::class;
    }
    public function getAllCategories(Request $request)
    {
        $query = Category::query();
        return $this->getAll($query, $request);
    }
}
