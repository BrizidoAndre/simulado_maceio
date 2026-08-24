<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'subscription_id',
        'amount',
        'transaction_date',
        'status',
        'usage_count',
        'worker_id',
        'description',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    protected function casts()
    {
        return [
            'transaction_date' => 'datetime',
        ];
    }

    #[Scope]
    protected function applyFilters(Builder $query)
    {
        $query->when(request('start_date'), function (Builder $query, $v) {
            $query->whereDate('transaction_date', '>=', $v);
        });
        $query->when(request('end_date'), function (Builder $query, $v) {
            $query->whereDate('transaction_date', '<=', $v);
        });
        $query->when(request('customer'), function (Builder $query, $v) {
            $query->whereHas('subscription', function ($query) use ($v) {
                $query->where('customer_id', $v);
            });
        });
        $query->when(request('plan'), function (Builder $query, $v) {
            $query->whereHas('subscription', function ($query) use ($v) {
                $query->where('plan_id', $v);
            });
        });
        $query->when(request('worker'), function (Builder $query, $v) {
            $query->where('worker_id', $v);
        });
        $query->when(request('status'), function (Builder $query, $v) {
            $query->where('status', $v);
        });
        return $query;
    }
}
