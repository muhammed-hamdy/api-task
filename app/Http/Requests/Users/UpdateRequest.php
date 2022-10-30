<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }


    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            response()->json([
            'errors' => $validator->errors()
        ], 400)
        );

    }
}
