@extends('layouts.app')

@if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@section('content')
<div x-data="{ open: true }">
    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Aprobar Orden de Trabajo #{{ $ordenTrabajo->num_ot ?? $ordenTrabajo->idorden }}</h2>

            <form method="POST" action="{{ route('ordenTrabajo.aprobar', $ordenTrabajo->idorden) }}">
                @csrf

                <div class="mb-3">
                    <label>Usuario (correo)</label>
                    <input type="text" name="correo" class="border p-2 w-full" required>
                </div>

                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="border p-2 w-full" required>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ url()->previous() }}" class="border px-4 py-2">Cancelar</a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2">Aprobar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
