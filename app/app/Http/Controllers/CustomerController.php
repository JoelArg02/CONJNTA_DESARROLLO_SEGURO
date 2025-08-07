<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::where('is_active', true)->get();
        $disabledCustomers = Customer::where('is_active', false)->get();

        $editingCustomer = null;
        if ($request->has('edit')) {
            $editingCustomer = Customer::find($request->input('edit'));
        }

        return view('admin.customers.index', [
            'customers' => $customers,
            'disabledCustomers' => $disabledCustomers,
            'editingCustomer' => $editingCustomer,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $customer = Customer::create($validated);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log('Cliente creado');

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'Cliente creado correctamente');
    }

    public function edit($id)
    {
        $customers = Customer::where('is_active', true)->get();
        $disabledCustomers = Customer::where('is_active', false)->get();
        $editingCustomer = Customer::findOrFail($id);

        return view('admin.customers.index', compact('customers', 'disabledCustomers', 'editingCustomer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $customer->update($validated);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log('Cliente actualizado');

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'Cliente actualizado correctamente');
    }

    public function destroy(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->invoices()->exists()) {
            return redirect()
                ->route('admin.customers.index')
                ->withErrors(['error' => 'No se puede desactivar el cliente porque tiene facturas asociadas.']);
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $customer->update([
            'is_active' => false,
            'deactivation_reason' => $request->reason,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->withProperties(['reason' => $request->reason])
            ->log('Cliente desactivado');

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'Cliente desactivado correctamente');
    }

    public function restore($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->is_active) {
            return redirect()
                ->route('admin.customers.index')
                ->withErrors(['error' => 'El cliente ya está activo']);
        }

        $customer->update([
            'is_active' => true,
            'deactivation_reason' => null,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log('Cliente reactivado');

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'Cliente reactivado correctamente');
    }
    
}
