<?php

namespace Laracommerce\Core\Products\Requests;

use Laracommerce\Core\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => ['required'],
            'name' => ['required', Rule::unique('products')->ignore($this->segment(3))],
            'quantity' => ['required', 'integer'],
            'price' => ['required']
        ];
    }
}
