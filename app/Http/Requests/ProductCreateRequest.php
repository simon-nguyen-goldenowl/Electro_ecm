<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:products|max:40',
            'cate_id' => 'required|integer|checkCateExisted',
            'brand_id' => 'required|integer|checkBrandExisted',
            'price' => 'required|integer',
            'amount' => 'required|integer'
        ];
    }
}
