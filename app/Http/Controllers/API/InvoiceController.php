<?php

namespace App\Http\Controllers\API;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Controllers\API\BaseController as BaseController;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $invoices = Invoice::with('customer')->get();
    return $invoices->map(function ($invoice) {
        return [
            'id'             => $invoice->id,
            // 'customer_id'    => $invoice->customer_id,
            'customer'       => $invoice->customer,
            'total_amount'   => $invoice->total_amount,
            'status'         => $invoice->status,
            'date'           => $invoice->date,
            'products'       =>  $invoice->product_details,
            // 'created_at'     => $invoice->created_at,
            // 'updated_at'     => $invoice->updated_at,
        ];
    });
}

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_id'      => 'required|exists:customers,id',
        'total_amount'     => 'required|numeric',
        'status'           => 'required|string',
        'date'             => 'nullable|date',
        'product_details'  => 'required|array',
    ]);

    if ($validator->fails()) {
        return $this->sendError('Validation Error', $validator->errors()->all());
    }


    try {
        $invoice = Invoice::create([
            'customer_id'     => $request->customer_id,
            'total_amount'    => $request->total_amount,
            'date'            => $request->date ?? Carbon::now()->toDateString(),
            'status'          => $request->status,
            // $invoice->product_details = json_decode($invoice->product_details); // ✅ decode for response
            // 'product_details' => $request->product_details,
            'product_details' => $request->product_details, // ✅ Store as array
        ]);

        return $this->sendResponse($invoice, 'Invoice Created Successfully.');
    } catch (Exception $e) {
        return $this->sendError('Failed to create invoice', [$e->getMessage()]);
    }
}


    protected function sendResponse($result, $message)
        {
            return response()->json([
                'success' => true,
                'data'    => $result,
                'message' => $message,
            ], 200);
        }

        protected function sendError($error, $errorMessages = [], $code = 400)
        {
            return response()->json([
                'success' => false,
                'message' => $error,
                'data'    => $errorMessages,
            ], $code);
        }
        
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
