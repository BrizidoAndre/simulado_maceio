<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionUpdateRequest extends FormRequest
{
    public function rules()
    {
        $model = request('model');
        return [
            'plan_id' => ['required', 'exists:plans,id',],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'customer_id' => ['required', 'exists:customers,id'],
        ];
    }

    public function messages()
    {
        return [
            'customer_id.exists' => 'The selected customer does not exist.',
            'customer_id.required' => 'The customer field is required.',
            'plan_id.required' => 'The plan field is required.',
            'plan_id.exists' => 'The selected plan does not exist.',
            'start_date.date_format' => 'The start date must be a valid date.',
            'start_date.date' => 'The start date must be a valid date.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
