<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //billed_to_line_2
        $search = $request->input('search');

        // Query invoices
        $query = Invoice::latest();

        // Apply filter if search parameter is present
        if ($search) {
            $query->where('billed_to_line_1', 'like', '%' . $search . '%')->where('billed_to_line_2', 'like', '%' . $search . '%')->where('billed_to_line_3', 'like', '%' . $search . '%');
        }

        // Paginate the results
        $invoices = $query->paginate(20);

        return response()->json($invoices, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'vat' => 'required|numeric',
            'date' => 'required|date',
            'service_charge' => 'required|numeric',
            'billed_to_line_1' => 'required|string|max:255',
            'billed_to_line_2' => 'required|string|max:255',
            'billed_to_line_3' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|numeric',
            'bank_name' => 'required|string|max:255',
            'line_items' => 'required|json',
            'currency' => 'sometimes|string',
            'discount' => 'sometimes',
        ]);
        $input = $request->all();
        $invoice = Invoice::create($input);

        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $invoice
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $invoice = Invoice::where('id', $id)->get();
        if (!$invoice) {
            return response()->json([
                'message' => "Invoice not found",
                'status' => 'error',
            ], 404);
        } else {
            return response()->json([
                'message' => "Success",
                'status' => 'success',
                'data' => $invoice
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'vat' => 'sometimes|numeric',
            'date' => 'sometimes|date',
            'service_charge' => 'sometimes|numeric',
            'billed_to_line_1' => 'sometimes|string|max:255',
            'billed_to_line_2' => 'sometimes|string|max:255',
            'billed_to_line_3' => 'sometimes|string|max:255',
            'account_name' => 'sometimes|string|max:255',
            'account_number' => 'sometimes|string',
            'bank_name' => 'sometimes|string|max:255',
            'line_items' => 'sometimes|json',
            'currency' => 'sometimes|string',
            'discount' => 'sometimes',
        ]);
        $invoice = Invoice::find($id);
        $invoice->update($data);

        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $invoice
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::destroy($id);
        return response()->json([
            'message' => "Success",
            'status' => 'success'
        ], 204);
    }
}
