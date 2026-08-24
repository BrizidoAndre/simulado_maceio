<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanCreateResource;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
//    default crud controller resource
//    with list, create, update and delete
    public function index()
    {
        return PlanResource::collection(Plan::all());
    }

    public function store(PlanRequest $request)
    {
        $model = Plan::create($request->validated());
        return PlanCreateResource::make($model);
    }

    public function show(Plan $model)
    {
        return PlanResource::make($model);
    }

    public function update(PlanRequest $request, Plan $model)
    {
        $model->update($request->validated());
        return PlanResource::make($model);
    }

    public function destroy(Plan $model)
    {
        if (count($model->subscriptions)) {
            throw new HttpResponseException(response()->json([
                'message' => 'It is not possible to delete a plan that has subscribed customers.'
            ], 400));
        }
        $model->delete();
        return response()->noContent();
    }
}
