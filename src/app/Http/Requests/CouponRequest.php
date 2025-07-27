<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // pega primeiro o model “coupon” (caso você tenha route-model binding)
        // senão pega diretamente o parâmetro numérico “id”
        $couponParam = $this->route('coupon');
        $id = $couponParam?->id ?? $this->route('id');

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                // agora ignora corretamente o ID do cupom que está sendo editado
                Rule::unique('coupons', 'code')->ignore($id),
            ],
            'discount_type'  => ['required', Rule::in(['fixed', 'percent'])],
            'discount_value' => 'numeric|min:0',
            'min_subtotal'   => 'numeric|min:0',
            'valid_from'     => 'nullable|date',
            'valid_to'       => 'nullable|date|after_or_equal:valid_from',
        ];
    }
}
