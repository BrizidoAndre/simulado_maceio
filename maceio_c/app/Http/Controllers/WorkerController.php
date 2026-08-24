<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCreateResource;
use App\Http\Resources\CustomerResource;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
{

//    default crud controller resource
//    with list, create, update and delete
    public function index()
    {
        return CustomerResource::collection(Worker::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:workers,name']
        ], [
            'name.unique' => 'The name is already in use.'
        ]);
        $model = Worker::create([
            ...$data,
        ]);
        return CustomerCreateResource::make($model);
    }

    public function show(Worker $model)
    {
        return CustomerResource::make($model);
    }

    public function update(Request $request, Worker $model)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('workers', 'name')->ignore($model)]
        ], [
            'name.unique' => 'The name is already in use.'
        ]);
        $model->update($data);
        return CustomerCreateResource::make($model);
    }

    public function destroy(Worker $model)
    {
        $transactions = $model->transactions()->where('status', 'Paid')->exists();
        if ($transactions) {
            $model->delete();
        } else {
            $model->forceDelete();
        }
        return response()->noContent();
    }
}
