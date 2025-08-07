<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Solo usuarios con rol Bodega o Administrador pueden acceder
        if (!Auth::user()->hasAnyRole(['Bodega', 'Administrador'])) {
            abort(403, 'Solo personal de bodega puede acceder a esta sección.');
        }

        // Si es una petición AJAX, devolver JSON
        if ($request->wantsJson()) {
            return response()->json(Product::where('is_active', true)->get());
        }
        
        // Si es una petición normal, devolver vista
        $products = Product::where('is_active', true)->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            $product = Product::create($validated);

            activity()
                ->causedBy(Auth::user())
                ->performedOn($product)
                ->log('Producto creado');

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Producto creado correctamente.'], 201);
            }

            return redirect()->route('dashboard')->with('status', 'Producto creado correctamente.');
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al guardar producto.'], 500);
            }
        }
    }


    public function create()
    {
        return view('admin.products.create');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ]);

        $product->update($validated);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($product)
            ->withProperties(['reason' => $validated['reason']])
            ->log('Producto editado');

        return response()->json(['message' => 'Producto actualizado']);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->invoiceItems()->exists()) {
            return response()->json(['error' => 'No se puede eliminar. Producto está en facturas.'], 422);
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $product->is_active = false;
        $product->deactivation_reason = $request->input('reason');
        $product->save();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($product)
            ->withProperties(['reason' => $request->input('reason')])
            ->log('Producto eliminado (soft)');

        return response()->json(['message' => 'Producto desactivado']);
    }

    public function disabled()
    {
        $products = Product::where('is_active', false)->get();
        return response()->json($products);
    }

    public function restore(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->is_active) {
            return response()->json(['message' => 'El producto ya está activo.'], 200);
        }

        $product->is_active = true;
        $product->deactivation_reason = null;
        $product->save();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($product)
            ->log('Producto reactivado');

        return response()->json(['message' => 'Producto reactivado correctamente']);
    }
}
