<?php

namespace App\Http\Requests\Colors;

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
            'name' => 'required|string',
            'year' => 'required|integer',
            'color' => 'required|string',
            'pantone_value' => 'required|string',
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
