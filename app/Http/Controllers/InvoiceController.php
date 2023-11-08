<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Services\TripayServices;
use Illuminate\Http\Request;
use Exception;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['product'])->get()->toArray();
        return array_reverse($invoices);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $method = $request->method;
        $tripay = new TripayServices();
    
        try {
            $hasil = $tripay->createTransaction($method, $product);
            $responseData = json_decode($hasil, true);
    
            // Periksa apakah atribut yang diharapkan ada dalam respons JSON
           
                $invoice = new Invoice([
                    'product_id' => $request->input('product_id'),
                    'merchant_ref' => $responseData['data']['merchant_ref'],
                    'tripay_references' => $responseData['data']['reference'],
                    'buyer_email' => $responseData['data']['customer_email'],
                    'buyer_phone' => $responseData['data']['customer_phone'],
                    'payment_status' => $responseData['data']['status'],
                    'checkout_url' => $responseData['data']['checkout_url'],
                ]);
    
                $invoice->save();
    
                return response()->json(['message' => 'Transaction created!', 'data' => $responseData['data']]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Transaction creation failed: ' . $e->getMessage()], 500);
        }
    }
    
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return $invoice->with(['product'])->find($invoice->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully', 200]);
    }
}
