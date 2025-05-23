<?php

namespace App\Http\Controllers\API;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Invoice::with('customer')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        // return response()->json(['message' => 'Invoice created successfully', 'data' => []]);
        
        //   dd($request->all());
        // dd($request->validated());
        // dd($request->all()); // Check incoming data
        //  $invoice = Invoice::create($request->validated());
        $validated = $request->validated();
        Log::debug('Invoice creation request:', $request->all());
        // $productDetails = $validated['product_details'] ?? null;
        
        // // dd($productDetails);
        // if (empty($productDetails)) {
        //     return response()->json(['error' => 'Product details missing.'], 422);
        // }

          $invoice = Invoice::create([
            // 'customer_id' => $validated->customer_id,
            // 'total_amount' => $validated->total_amount,
            // 'date' => $validated->date,
            // 'status' => $validated->status,

            'customer_id' => $validated['customer_id'],
            'total_amount' => $validated['total_amount'],
            'date' => $validated['date'],
            'status' => $validated['status'],
            'product_details' => $validated['product_details'],
            // 'product_details' => $productDetails,


            // 'product_details' => $validated->product_details,
        ]);
        // dd($invoice);
        return response()->json(['message' => 'Invoice created successfully', 'data' => $invoice]);

        // dd($request->all());
        // return response()->json($invoice);
        // return $this->sendResponse($invoice, 'Invoice Created Successfully.');

        // return response()->json([
        //     'message' => 'Invoice created successfully',
        //     'data' => $invoice,
        // ], 201);
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
