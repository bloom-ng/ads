<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        //
        $user = User::where('email', $request->email)->first();
        if($user && !Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => 'error', 
                'message' => 'incorrect password'
            ]);
        } elseif (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'user not found'
            ]);
        } else {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
        
            $response = [
                'message' => 'Login successful',
                'status' => 'success',
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
        }
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
        //validate request
        $request->validate([
            'name' => 'required|string|max:255',    
            'email' => 'required|string|email|max:255|unique:users',    
            'password' => 'required|string|min:8', 
        ]);

        $checkUser = User::where('email', $request->email)->first();
        
        if($checkUser){
            return response()->json([
                'status' => 'error',
                'message' => 'User already exists'
            ]);
        } else {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);

            $tokenResult = $user->createToken('Personal Access Token')->plainTextToken;
            // $token = $tokenResult->token;
            // $token = $tokenResult->save();

            $response = [
                'message' => 'User created',
                'status' => 'Success',
                'user' => $user,
                'token' => $tokenResult
            ];

            return response()->json($response, 201);
        }

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
