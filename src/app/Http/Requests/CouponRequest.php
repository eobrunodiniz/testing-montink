<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request para validação de cupons.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class CouponRequest extends FormRequest
{
    /**
     * {@inheritdoc}
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        $couponParam = $this->route('coupon');
        $id = $couponParam?->id ?? $this->route('id');

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($id),
            ],
            'discount_type' => ['required', Rule::in(['fixed', 'percent'])],
            'discount_value' => 'numeric|min:0',
            'min_subtotal' => 'numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ];
    }
}
