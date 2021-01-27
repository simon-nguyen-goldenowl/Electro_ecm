<?php

namespace App\Services;

use App\Enums\RedisKeyType;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CategoryService extends CommonService
{
    public function getModel()
    {
        return Category::class;
    }
    public function getAllCategories(Request $request)
    {
        if (!Redis::get(RedisKeyType::Category)) {
            $cate_list = serialize(Category::all());
            Redis::set(RedisKeyType::Category, $cate_list);
            Redis::expire(RedisKeyType::Category, 180);
        }
        $cate_list = unserialize(Redis::get(RedisKeyType::Category));
        return $cate_list;
    }
}
