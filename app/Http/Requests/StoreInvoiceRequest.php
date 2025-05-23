<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'], // ISO format e.g., 2025-05-22
            'status' => ['required', 'in:pending,paid'],
            // 'product_details' => ['nullable', 'array', 'min:1'],
            'product_details' => ['required','string'],
        ];
    }
}