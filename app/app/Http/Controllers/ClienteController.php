<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class ClienteController extends Controller
{
    public function showLoginForm()
    {
        return view('clientes.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();
        if ($customer && Hash::check($request->password, $customer->password)) {
            Auth::guard('customer')->login($customer);
            return redirect()->route('clientes.dashboard');
        }
        return back()->withErrors(['email' => 'Credenciales incorrectas'])->onlyInput('email');
    }

    public function dashboard()
    {
        $cliente = Auth::guard('customer_web')->user();
        $tokens = $cliente->tokens()->get(); 
        $invoices = $cliente->invoices()->latest()->get();

        return view('clientes.dashboard', compact('cliente', 'tokens', 'invoices'));
    }
}
