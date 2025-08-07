<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'device_name' => ['required', 'string'],
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (! $customer) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        // Generar token sin validar contraseña
        $token = $customer->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'customer' => $customer->only(['id', 'name', 'email']),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token revocado']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
