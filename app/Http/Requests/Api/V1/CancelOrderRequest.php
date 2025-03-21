<?php

namespace App\Http\Requests\Api\V1;
use Illuminate\Validation\Rule;

class CancelOrderRequest extends BaseFormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
                Rule::exists('orders', 'id')->where(fn ($query) => $query->where('status', '!=', 'cancelled')),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The selected order does not exist or has already been cancelled.',
        ];
    }

}
