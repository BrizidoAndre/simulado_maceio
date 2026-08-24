<?php

namespace App\Http\Resources;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Subscription */
class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'plan_id' => $this->plan_id,
            'start_date' => $this->start_date->format('Y-m-d'),
            'plan' => new PlanResource($this->whenLoaded('plan')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
