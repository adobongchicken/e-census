@props(['active' => false])
<a {{ $attributes }}
    class="w-full border-red-700 border p-2 py-3 text-center cursor-pointer text-sm font-medium {{ $active ? 'bg-red-600 text-white' : '' }}">{{ $slot }}
</a>
