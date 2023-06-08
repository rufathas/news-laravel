<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

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
            'status' => ['required', 'string',Rule::in(config('constants.news_status'))],
            'data' => ['required', 'array'],
            'data.*.locale' => ['required', 'string',Rule::in(config('translatable.locales'))],
            'data.*.title' => ['required', 'string','max:255'],
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
            'status.required' => 'A description is required'
        ];
    }


    /**
     * @throws ValidationErrorException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        throw new ValidationErrorException($errors,400);
    }
}
