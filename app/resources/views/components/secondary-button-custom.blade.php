<style>
.btn-secondary-custom {
    border: 2px solid #667eea;
    color: #667eea;
    transition: all 0.3s ease;
}
</style>

<a {{ $attributes->merge(['class' => 'btn-secondary-custom px-4 py-2 rounded-lg font-medium text-sm']) }}>
    {{ $slot }}
</a>
