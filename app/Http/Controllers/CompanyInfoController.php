<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyInfo = CompanyInfo::all();
        return response()->json([
            'message' => "Success",
            'status' => 'success',
            'data' => $companyInfo
        ], 200);
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
        //
        $request->validate([
            "address_line_1" => 'required|string|max:255',
            "address_line_2" => 'required|string|max:255',
            "address_line_3" => 'required|string|max:255',
            "email" => 'required|string|email|max:255',
            "phone" => 'required|numeric|min:10|max:12',
            "phone_2" => 'numeric|min:10|max:12',
        ]);

        $input = $request->all();
        $companyInfo = CompanyInfo::create($input);

        return response()->json([
            'message' => 'Success',
            'status' => 'success',
            'data' => $companyInfo,
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
        $companyInfo = CompanyInfo::where('id', $id)->get();
        if (!$companyInfo) {
            return response()->json([
                'message' => "Company Info not found",
                'status' => 'error',
            ], 404);
        } else {
            return response()->json([
                'message' => "Success",
                'status' => 'success',
                'data' => $companyInfo
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
