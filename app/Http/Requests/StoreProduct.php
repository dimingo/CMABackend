<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProduct extends FormRequest
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
            //
            'name' => 'required|string|unique:products,name',
            'description' => 'required|string|max:255',
            'price' => 'required|decimal:2,4',

        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'code' => 422,
                'success' => false,
                'errors' => $validator->errors()
            ], 422)
        );
    }

    public function messages()
    {
        return [

            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.unique' => 'The name has already been taken.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description field must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'price.required' => 'The price field is required.',
            'price.decimal' => 'The price field must be a decimal.',
            'price.gt' => 'The price must be greater than 0.',

        ];
    }
}
