<?php

namespace App\Http\Resources;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Plan */
class PlanCreateResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'monthly_usage_limit' => $this->monthly_usage_limit,
            'id' => $this->id,
        ];
    }
}
