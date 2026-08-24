<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transaction */
class TransactionResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'subscription_id' => $this->subscription_id,
            'amount' => $this->amount,
            'transaction_date' => $this->transaction_date->format('Y-m-d H:i:s'),
            'status' => mb_strtolower($this->status),
            'worker_id' => $this->worker_id,
            'usage_count' => $this->usage_count,
            'description' => $this->description,
            'worker' => $this->worker,
            'subscription' => new TransactionSubscriptionResource($this->subscription),
        ];
    }
}
