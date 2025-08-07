<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="{{ $header['class'] ?? 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider' }}">
                            {!! $header['label'] !!}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($pagination ?? false)
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $pagination }}
        </div>
    @endif
</div>
