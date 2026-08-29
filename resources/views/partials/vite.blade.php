@if (file_exists(public_path('build/manifest.json')))
    {{-- When Vite manifest exists, use Vite helper --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    {{-- Fallback to prebuilt assets in public/ when manifest is missing (Hostinger without Node) --}}
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}">
    <script src="{{ asset('js/scps.js') }}" defer></script>
@endif
