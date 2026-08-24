<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\SubscriptionUpdateRequest;
use App\Http\Resources\SubscriptionCreateResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
//    default crud controller resource
//    with list, create, update and delete
    public function index()
    {
        $subscription = Subscription::with(['customer', 'plan'])->get();
        return SubscriptionResource::collection($subscription);
    }

    public function store(SubscriptionRequest $request)
    {
        $model = Subscription::create($request->validated());
        $model->transactions()->create([
            'amount' => $model->plan->price,
            'transaction_date' => Carbon::now(),
            'usage_count' => 1,
        ]);
        return SubscriptionCreateResource::make($model);
    }

    public function show(Subscription $model)
    {
        $model->load(['plan', 'customer']);
        return SubscriptionResource::make($model);
    }

    public function update(SubscriptionUpdateRequest $request, Subscription $model)
    {
        if ($model->plan_id !== $request->input('plan_id')) {
            $model->transactions()->where('status', 'Pending')->update([
                'status' => 'Cancelled',
            ]);
            $model->update($request->validated());
            $model->transactions()->create([
                'amount' => $model->plan->price,
                'transaction_date' => Carbon::now(),
                'usage_count' => 1,
            ]);
        }
        return SubscriptionCreateResource::make($model);
    }

    public function destroy(Subscription $model)
    {
        $model->delete();
        return response()->noContent();
    }

//    suspend this current transaction
    public function suspend(Subscription $model)
    {
        $model->transactions()->where('status', 'Pending')->update([
            'status' => 'Cancelled'
        ]);
        return response()->noContent();
    }
}
