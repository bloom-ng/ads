<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Receipt::latest();
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('billed_to_line_1', 'like', '%' . $search . '%')
                    ->orWhere('billed_to_line_2', 'like', '%' . $search . '%')
                    ->orWhere('billed_to_line_3', 'like', '%' . $search . '%');
            });
        }
        $receipts = $query->paginate(20);
        return response()->json($receipts, 200);
    }

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
        $receipt = Receipt::create($input);
        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $receipt
        ], 201);
    }

    public function show($id)
    {
        $receipt = Receipt::where('id', $id)->get();
        if (!$receipt) {
            return response()->json([
                'message' => "Receipt not found",
                'status' => 'error',
            ], 404);
        } else {
            return response()->json([
                'message' => "Success",
                'status' => 'success',
                'data' => $receipt
            ], 200);
        }
    }

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
        $receipt = Receipt::find($id);
        $receipt->update($data);
        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $receipt
        ], 200);
    }

    public function destroy($id)
    {
        Receipt::destroy($id);
        return response()->json([
            'message' => "Success",
            'status' => 'success'
        ], 204);
    }
} 