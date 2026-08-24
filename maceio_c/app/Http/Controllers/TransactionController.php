<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaidTransactionResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction
            ::with(['subscription.plan', 'subscription.customer'])
            ->applyFilters()
            ->get();
        return TransactionResource::collection($transactions);
    }

//    update the transaction with custom errors
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'worker_id' => ['required', 'exists:workers,id'],
            'transaction_date' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'integer:strict', 'min:0'],
            'usage_count' => ['required', 'integer:strict', 'min:1'],
            'description' => ['string:strict'],
        ], [
            'worker_id.exists' => 'The selected worker does not exists.',
            'transaction_date.date_format' => 'The transaction date must be a valid date.',
            'amount.integer' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.',
            'usage_count.integer' => 'The usage count must be an integer.',
            'usage_count.min' => 'The usage count must be at least 1.',
        ]);
        $nextThirtyMinutes = Carbon::createFromFormat('Y-m-d', $data['transaction_date']);
        $nextThirtyMinutes = $nextThirtyMinutes->setHour((int)Carbon::now()->format('H'));
        $nextThirtyMinutes = $nextThirtyMinutes->setMinutes((int)Carbon::now()->format('i'));
        $nextThirtyMinutes = $nextThirtyMinutes->setSeconds((int)Carbon::now()->format('s'));
        $nextThirtyMinutes = $nextThirtyMinutes->addMinutes(30);
//        check if worker has already a transaction in this time
        $workerBusy = Transaction
            ::where('worker_id', $data['worker_id'])
            ->whereDate('transaction_date', '>=', $data['transaction_date'])
            ->whereDate('transaction_date', '<=', $nextThirtyMinutes->format('Y-m-d H:i:s'))
            ->exists();
        if ($workerBusy) {
            throw new HttpResponseException(response()->json([
                'message' => 'This professional already has a service scheduled for this time slot.'
            ], 422));
        }
        $transaction->update($data);
        $transaction->load(['subscription.plan', 'subscription.customer', 'worker']);
        return TransactionResource::make($transaction);
    }

//    creates the next transaction automatically
    public function paid(Transaction $transaction)
    {
        if ($transaction->status === 'Suspended') {
            throw new HttpResponseException(response()->json([
                'message' => 'Inactive subscription',
            ], 404));
        }
        $errors = [];
        if (!$transaction->worker) {
            $errors[] = 'The transaction must be associated with a professional in order to be marked as paid.';
        }
        if ($transaction->status !== 'Pending') {
            $errors[] = 'The transaction is already marked as finalized.';
        }
        if (count($errors)) {
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ], 400));
        }
        $transaction->update([
            'status' => $transaction->amount !== 0 ? 'Paid' : 'Not apply'
        ]);
        $transaction->load(['subscription.customer', 'subscription.plan']);
        $usageCount = $transaction->usage_count === $transaction->subscription->plan->monthly_usage_limit ? 1 : $transaction->usage_count + 1;
        $amount = $usageCount !== 1 ? 0 : $transaction->subscription->plan->price;
        $carbon = $transaction->transaction_date;
        $nextDate = $carbon->setDay((int)$carbon->format('d') + (30 / $transaction->subscription->plan->monthly_usage_limit));
        $nextTransaction = Transaction::create([
            'subscription_id' => $transaction->subscription_id,
            'status' => 'Pending',
            'transaction_date' => $nextDate,
            'usage_count' => $usageCount,
            'amount' => $amount,
        ]);
        return PaidTransactionResource::make($transaction);
    }
}
