<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voucher = Voucher::latest()->paginate(20);
        return response()->json($voucher, 200);
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
            'place' => 'required|string',
            'expense_head' => 'required|string',
            'month' => 'required|string',
            'date' => 'required|date',
            'beneficiary' => 'required|string|max:255',
            'amount_words' => 'required|string|max:255',
            'cash_cheque_no' => 'required|string|max:255',
            'prepared_by' => 'required|string',
            'examined_by' => 'required|string|max:255',
            'authorized_for_payment' => 'required|string',
            'date_prepared' => 'sometimes|date',
            'line_items' => 'required|json',
            'currency' => 'sometimes',
        ]);
        $input = $request->all();
        $voucher = Voucher::create($input);

        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $voucher
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
        $voucher = Voucher::where('id', $id)->get();
        if (!$voucher) {
            return response()->json([
                'message' => "Invoice not found",
                'status' => 'error',
            ], 404);
        } else {
            return response()->json([
                'message' => "Success",
                'status' => 'success',
                'data' => $voucher
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
            'place' => 'required|string',
            'expense_head' => 'required|string',
            'month' => 'required|string',
            'date' => 'required|date',
            'beneficiary' => 'required|string|max:255',
            'amount_words' => 'required|string|max:255',
            'cash_cheque_no' => 'required|string|max:255',
            'prepared_by' => 'required|string',
            'examined_by' => 'required|string|max:255',
            'authorized_for_payment' => 'required|string',
            'date_prepared' => 'sometimes|date',
            'line_items' => 'required|json',
            'currency' => 'sometimes',
        ]);
        $voucher = Voucher::find($id);
        $voucher->update($data);

        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $voucher
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
        Voucher::destroy($id);
        return response()->json([
            'message' => "Success",
            'status' => 'success'
        ], 204);
    }
}
