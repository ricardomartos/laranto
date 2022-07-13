<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:25',
            'description' => 'required',
            'sku' => 'required|max:20',
            'in_stock' => 'boolean',
            'price' => 'required',
            'product_id' => 'sometimes|exists:products,id',
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id', // check each item in the array
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Your request has some errors',
                'data' => $validator->errors()
            ], 422)
        );
    }
}
