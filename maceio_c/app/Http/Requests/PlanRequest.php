<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
{
    public function rules()
    {
        $model = request("model");
        return [
            'name' => ['required', 'string:strict', Rule::unique('plans', 'name')->ignore($model)],
            'price' => ['required', 'integer:strict', 'min:1'],
            'monthly_usage_limit' => ['required', 'integer:strict', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The name must be a string.',
            'name.unique' => 'The name is already in use.',
            'price.min' => 'The price must be at least 1.',
            'price.integer' => 'The price must be a number.',
            'monthly_usage_limit.min' => 'The  monthly usage limit must be at least 1.',
            'monthly_usage_limit.integer' => 'The monthly usage limit must be an integer.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
