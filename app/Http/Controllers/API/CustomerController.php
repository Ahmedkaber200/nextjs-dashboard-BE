<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class CustomerController extends BaseController

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Customer::select('id', 'name', 'email', 'contact', 'address')->get()
        ]);
        // $data = Customer::all();
        // return $this->sendResponse($data, 'All Customer Data.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateCustomer = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'contact' => 'required',
                'address' => 'required',
            ]
        );

        if ($validateCustomer->fails()) {
            return $this->sendError('Validation Error', $validateCustomer->errors()->all());
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return $this->sendResponse($customer, 'Customer Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Customer::select(
            'id',
            'name',
            'email',
            'contact',
            'address'
        )->where(['id' => $id])->first();

        return $this->sendResponse($data, 'My Single Customer Fetch.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateCustomer = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'contact' => 'required',
                'address' => 'required',
            ]
        );

        if ($validateCustomer->fails()) {
            return $this->sendError('Validation Error', $validateCustomer->errors()->all());
        }

        $customer = Customer::where(['id' => $id])->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return $this->sendResponse($customer, 'Customer Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::where('id' ,$id)->delete();
        return $this->sendResponse($customer, 'My Customer data has been removed.');
    }
}
