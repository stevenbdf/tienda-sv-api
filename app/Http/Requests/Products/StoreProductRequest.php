<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\Nullable;

class StoreProductRequest extends FormRequest
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
            'name' => ['required','string'],
            'img' => ['required','url'],
            'description' => ['nullable','string'],
            'regular_price' => ['required','numeric'],
            'sale_price' => ['required','numeric','gte:regular_price'],
            'stock_qty' => ['required','integer','min:1'],
        ];
    }
}
