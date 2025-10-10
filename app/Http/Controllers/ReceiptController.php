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
            'amount_paid' => 'sometimes|numeric',
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
            'amount_paid' => 'sometimes|numeric',
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

    /**
     * Confirm a receipt using the receipt code format (REC + date + id)
     * Example: REC2025100612 (REC + 20251006 + 12)
     */
    public function confirm($receiptCode)
    {
        // Validate the receipt code format
        if (!preg_match('/^REC(\d{8})(\d+)$/', $receiptCode, $matches)) {
            return response()->json([
                'message' => 'Invalid receipt code format',
                'status' => 'error'
            ], 400);
        }

        $dateCreated = $matches[1]; // 20251006
        $receiptId = $matches[2];   // 12

        // Parse the date from YYYYMMDD format
        $parsedDate = \DateTime::createFromFormat('Ymd', $dateCreated);
        if (!$parsedDate) {
            return response()->json([
                'message' => 'Invalid date in receipt code',
                'status' => 'error'
            ], 400);
        }

        // Find the receipt by ID and verify the date matches
        $receipt = Receipt::find($receiptId);

        if (!$receipt) {
            return response()->json([
                'message' => 'Receipt not found',
                'status' => 'error'
            ], 404);
        }

        // Check if the receipt date matches the date in the code
        $receiptDate = $receipt->date->format('Ymd');
        if ($receiptDate !== $dateCreated) {
            return response()->json([
                'message' => 'Receipt code does not match receipt data',
                'status' => 'error'
            ], 400);
        }

        // Return the confirmed receipt data
        return response()->json([
            'message' => 'Receipt confirmed successfully',
            'status' => 'success',
            'data' => [
                'receipt_code' => $receiptCode,
                'receipt_id' => $receipt->id,
                'date_created' => $receipt->date->format('Y-m-d H:i:s'),
                'billed_to' => [
                    'line_1' => $receipt->billed_to_line_1,
                    'line_2' => $receipt->billed_to_line_2,
                    'line_3' => $receipt->billed_to_line_3,
                ],
                'account_details' => [
                    'account_name' => $receipt->account_name,
                    'account_number' => $receipt->account_number,
                    'bank_name' => $receipt->bank_name,
                ],
                'amount_paid' => $receipt->amount_paid,
                'currency' => $receipt->currency,
                'vat' => $receipt->vat,
                'service_charge' => $receipt->service_charge,
                'discount' => $receipt->discount,
                'line_items' => json_decode($receipt->line_items, true),
                'confirmed_at' => now()->toISOString(),
            ]
        ], 200);
    }
}
