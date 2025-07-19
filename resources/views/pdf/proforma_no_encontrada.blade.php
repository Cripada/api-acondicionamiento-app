<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <title>Proforma no encontrada</title>
        <style>
            {!! file_get_contents(public_path('css/estilo_proforma_no_encontrada.css')) !!}
        </style>
    </head>
    <body>
        <div class="container">
            @php
                $logo = base64_encode(file_get_contents(public_path('logo/cripada-logo-azul.svg')));
            @endphp
            <div class="logo">
                <img src="data:image/svg+xml;base64,{{ $logo }}" alt="Logo Cripada" style="width: 400px;">
            </div>
            <h1>Proforma No Encontrada</h1>
            <p>La proforma solicitada no ha podido ser localizada en nuestro sistema.</p>
            <p>Por favor verifique el número ingresado o contacte al departamento administrativo para más información.</p>

            <div class="footer">
                CRIPADA S.A. &mdash; Gestión de Proformas
            </div>
        </div>
    </body>
</html>
