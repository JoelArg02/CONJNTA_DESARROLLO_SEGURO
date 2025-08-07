<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de Actividades (Auditorías)</h2>
            <div class="flex gap-2">
                @if(request('search') || request('entity') || request('event'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Filtros aplicados
                    </span>
                @endif
                <a href="#" onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Exportar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('admin.activities.index') }}" class="mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <x-text-input 
                                id="search"
                                type="text" 
                                name="search" 
                                placeholder="Descripción, usuario, motivo..."
                                value="{{ request('search') }}" 
                                class="w-full" />
                        </div>
                        
                        <div>
                            <label for="entity" class="block text-sm font-medium text-gray-700 mb-1">Entidad</label>
                            <select name="entity" id="entity" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todas las entidades</option>
                                @foreach($entityTypes as $entityType)
                                    <option value="{{ $entityType['value'] }}" {{ request('entity') === $entityType['value'] ? 'selected' : '' }}>
                                        {{ $entityType['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="event" class="block text-sm font-medium text-gray-700 mb-1">Evento</label>
                            <select name="event" id="event" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos los eventos</option>
                                @foreach($eventTypes as $eventType)
                                    <option value="{{ $eventType['value'] }}" {{ request('event') === $eventType['value'] ? 'selected' : '' }}>
                                        {{ $eventType['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end gap-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Filtrar
                            </button>
                            <a href="{{ route('admin.activities.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Summary Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Actividades</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activities->total() }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Creaciones</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activities->where('event', 'created')->count() }}</p>
                        </div>
                    </div>
                </div> --}}
                
                {{-- <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Actualizaciones</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activities->where('event', 'updated')->count() }}</p>
                        </div>
                    </div>
                </div> --}}
                
                {{-- <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Eliminaciones</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activities->where('event', 'deleted')->count() }}</p>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-gray-700 text-left">
                            <tr>
                                <th class="px-4 py-2 font-medium">Fecha</th>
                                <th class="px-4 py-2 font-medium">Descripción</th>
                                <th class="px-4 py-2 font-medium">Usuario</th>
                                <th class="px-4 py-2 font-medium">Entidad</th>
                                <th class="px-4 py-2 font-medium">Usuario que Modifica</th>
                                <th class="px-4 py-2 font-medium">Motivo</th>
                                <th class="px-4 py-2 font-medium">Evento</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($activities as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm">
                                        {{ $activity->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ $activity->description }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($activity->subject_type && $activity->subject)
                                            @if($activity->subject_type === 'App\Models\User')
                                                {{ $activity->subject->name ?? 'Usuario eliminado' }}
                                            @elseif($activity->subject_type === 'App\Models\Invoice')
                                                Factura #{{ $activity->subject->invoice_number ?? $activity->subject_id }}
                                            @elseif($activity->subject_type === 'App\Models\Product')
                                                {{ $activity->subject->name ?? 'Producto eliminado' }}
                                            @elseif($activity->subject_type === 'App\Models\Customer')
                                                {{ $activity->subject->name ?? 'Cliente eliminado' }}
                                            @else
                                                {{ $activity->subject->name ?? $activity->subject->title ?? "ID: {$activity->subject_id}" }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($activity->subject_type)
                                            @php
                                                $entityNames = [
                                                    'App\Models\User' => 'Usuario',
                                                    'App\Models\Invoice' => 'Factura',
                                                    'App\Models\Product' => 'Producto',
                                                    'App\Models\Customer' => 'Cliente',
                                                    'App\Models\InvoiceItem' => 'Item de Factura',
                                                ];
                                                $entityName = $entityNames[$activity->subject_type] ?? class_basename($activity->subject_type);
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($activity->subject_type === 'App\Models\User') bg-blue-100 text-blue-800
                                                @elseif($activity->subject_type === 'App\Models\Invoice') bg-green-100 text-green-800
                                                @elseif($activity->subject_type === 'App\Models\Product') bg-purple-100 text-purple-800
                                                @elseif($activity->subject_type === 'App\Models\Customer') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $entityName }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ optional($activity->causer)->name ?? 'Sistema' }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($activity->properties && isset($activity->properties['reason']))
                                            <span class="text-gray-600 italic">{{ $activity->properties['reason'] }}</span>
                                        @elseif($activity->properties && isset($activity->properties['old_status']) && isset($activity->properties['new_status']))
                                            <span class="text-gray-600 italic">
                                                Estado: {{ $activity->properties['old_status'] }} → {{ $activity->properties['new_status'] }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($activity->event)
                                            @php
                                                $eventLabels = [
                                                    'created' => 'Creado',
                                                    'updated' => 'Actualizado',
                                                    'deleted' => 'Eliminado',
                                                    'restored' => 'Restaurado',
                                                ];
                                                $eventLabel = $eventLabels[$activity->event] ?? ucfirst($activity->event);
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($activity->event === 'created') bg-green-100 text-green-800
                                                @elseif($activity->event === 'updated') bg-blue-100 text-blue-800
                                                @elseif($activity->event === 'deleted') bg-red-100 text-red-800
                                                @elseif($activity->event === 'restored') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $eventLabel }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $activities->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
