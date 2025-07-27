<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as regras de validação para o formulário de checkout.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function rules(): array
    {
        return [
            'email' => 'email',
            'cep' => 'max:20',
            'number' => 'max:255',
            'district' => 'max:100',
            'city' => 'max:100',
            'state' => 'max:100',
            'coupon_code' => 'max:100',
        ];
    }
}
