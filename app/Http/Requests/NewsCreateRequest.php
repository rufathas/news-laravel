<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class NewsCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'string'],
            'data' => ['required', 'array'],
            'data.*.locale' => ['required', 'string'],
            'data.*.title' => ['required', 'string'],
            'data.*.description' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'description.required' => 'A description is required',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        dd($errors);
    }
}
