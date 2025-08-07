<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entity = $request->input('entity');
        $event = $request->input('event');

        $activities = Activity::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                      ->orWhereHas('causer', function ($causerQuery) use ($search) {
                          $causerQuery->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereRaw("properties->>'reason' ILIKE ?", ["%{$search}%"]);
                });
            })
            ->when($entity, function ($query) use ($entity) {
                $query->where('subject_type', $entity);
            })
            ->when($event, function ($query) use ($event) {
                $query->where('event', $event);
            })
            ->with(['causer', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get unique entity types for filter
        $entityTypes = Activity::select('subject_type')
            ->distinct()
            ->whereNotNull('subject_type')
            ->pluck('subject_type')
            ->map(function ($type) {
                $entityNames = [
                    'App\Models\User' => 'Usuario',
                    'App\Models\Invoice' => 'Factura',
                    'App\Models\Product' => 'Producto',
                    'App\Models\Customer' => 'Cliente',
                    'App\Models\InvoiceItem' => 'Item de Factura',
                ];
                return [
                    'value' => $type,
                    'label' => $entityNames[$type] ?? class_basename($type)
                ];
            });

        // Get unique event types for filter
        $eventTypes = Activity::select('event')
            ->distinct()
            ->whereNotNull('event')
            ->pluck('event')
            ->map(function ($event) {
                $eventLabels = [
                    'created' => 'Creado',
                    'updated' => 'Actualizado',
                    'deleted' => 'Eliminado',
                    'restored' => 'Restaurado',
                ];
                return [
                    'value' => $event,
                    'label' => $eventLabels[$event] ?? ucfirst($event)
                ];
            });

        return view('admin.activities.index', compact('activities', 'search', 'entity', 'event', 'entityTypes', 'eventTypes'));
    }
}
