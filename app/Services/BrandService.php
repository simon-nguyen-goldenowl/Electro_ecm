<?php

namespace App\Services;

use App\Enums\RedisKeyType;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BrandService extends CommonService
{
    public function getModel()
    {
        return Brand::class;
    }
    public function getAllBrands(Request $request)
    {
        if (!Redis::get(RedisKeyType::Brand)) {
            $brand_list = serialize(Brand::all());
            Redis::set(RedisKeyType::Brand, $brand_list);
            Redis::expire(RedisKeyType::Brand, 180);
        }
        $brand_list = unserialize(Redis::get(RedisKeyType::Brand));
        return $brand_list;
    }
}
