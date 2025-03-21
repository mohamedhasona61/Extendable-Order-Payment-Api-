<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;
use App\Http\Requests\Api\V1\BaseFormRequest;

class OrderRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string',
            'shipping_address.email' => 'required|email',
            'shipping_address.phone' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.address' => 'required|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => [
                'required',
                'integer',
                'min:1',
                Rule::exists('payment_gateways', 'id')->where(fn($query) => $query->where('status', 'active')),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'shipping_address.required' => 'Shipping address is required.',
            'shipping_address.array' => 'Shipping address must be a valid array.',

            'shipping_address.name.required' => 'Name is required.',
            'shipping_address.name.string' => 'Name must be a string.',

            'shipping_address.email.required' => 'Email is required.',
            'shipping_address.email.email' => 'Email must be a valid email address.',

            'shipping_address.phone.required' => 'Phone number is required.',
            'shipping_address.phone.string' => 'Phone number must be a string.',

            'shipping_address.city.required' => 'City is required.',
            'shipping_address.city.string' => 'City must be a string.',

            'shipping_address.address.required' => 'Address is required.',
            'shipping_address.address.string' => 'Address must be a string.',

            'products.required' => 'At least one product is required.',
            'products.array' => 'Products must be a valid array.',

            'products.*.product_id.required' => 'Product ID is required.',
            'products.*.product_id.exists' => 'The selected product ID does not exist.',

            'products.*.quantity.required' => 'Quantity is required.',
            'products.*.quantity.integer' => 'Quantity must be an integer.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',

            'payment_method.required' => 'Payment method is required.',
            'payment_method.integer' => 'Payment method must be a valid integer.',
            'payment_method.min' => 'Payment method must be a positive number.',
            'payment_method.exists' => 'The selected payment method is invalid or inactive.',
        ];
    }
}
