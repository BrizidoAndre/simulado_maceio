<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCreateResource;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

//    default crud controller resource
//    with list, create, update and delete
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:customers,name']
        ], [
            'name.unique' => 'The name is already in use.'
        ]);
        $model = Customer::create([
            ...$data,
        ]);
        return CustomerCreateResource::make($model);
    }

    public function show(Customer $model)
    {
        return CustomerResource::make($model);
    }

    public function update(Request $request, Customer $model)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('customers', 'name')->ignore($model)]
        ], [
            'name.unique' => 'The name is already in use.'
        ]);
        $model->update($data);
        return CustomerCreateResource::make($model);
    }

    public function destroy(Customer $model)
    {
        $model->delete();
        return response()->noContent();
    }
}
