<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:40|unique:products,name,' . $this->product,
            'cate_id' => 'required|integer|checkCateExisted',
            'brand_id' => 'required|integer|checkBrandExisted',
            'price' => 'required|integer',
            'amount' => 'required|integer',
        ];
    }
}
