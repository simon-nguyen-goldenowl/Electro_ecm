<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('user', session()->get('user'));

        //CATEGORY EXIST VALIDATION
        Validator::extend('checkCateExisted', function ($attribute, $value, $parameters, $validator) {
            $Category = Category::find($value);
            return $Category != null;
        });
        Validator::replacer('checkCateExisted', function ($message, $attribute, $rule, $parameters) {
            return str_replace('validation.checkCateExisted', 'validation.checkCateExisted', 'Category is not existed');
        });
        //BRAND EXIST VALIDATION
        Validator::extend('checkBrandExisted', function ($attribute, $value, $parameters, $validator) {
            $Brand = Brand::find($value);
            return $Brand != null;
        });
        Validator::replacer('checkBrandExisted', function ($message, $attribute, $rule, $parameters) {
            return str_replace('validation.checkBrandExisted', 'validation.checkBrandExisted', 'brand is not existed');
        });
    }
}
