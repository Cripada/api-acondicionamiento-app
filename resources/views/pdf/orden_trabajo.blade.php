<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Orden de Trabajo N.º {{ str_pad($orden['idorden'], 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        {!! file_get_contents(public_path('css/estilo_orden_trabajo.css')) !!}
    </style>
</head>

<body>
    <!-- Encabezado -->
    <div class="headerDos">
        <div class="header clearfix">
            <div class="header-left">
                @php
                    $logo = base64_encode(file_get_contents(public_path('logo/cripada-logo.svg')));
                @endphp
                <img src="data:image/svg+xml;base64,{{ $logo }}" alt="Logo" style="width: 250px;">
                <div class="tagline">"Comprometidos con la calidad y el cumplimiento."</div>
            </div>
            <div class="header-right">
                <div class="invoice-label">ORDEN DE TRABAJO</div>
                <div class="invoice-info">
                    <strong>Inicia: </strong> {{ $orden['fecha_inicio'] }}<br>
                    <strong>Finaliza: </strong> {{ $orden['fecha_fin'] }}<br>
                    <div>
                        <strong>N.º Orden:</strong> <strong
                            class="nproforma">{{ str_pad($orden['idorden'], 6, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección información general -->
    <div class="section">
        <h2>Información General</h2>
        <div class="info">
            <p><strong>Cliente:</strong> {{ strtoupper($orden['proforma']['cliente']['nombre_comercial']) }}</p>
            <p><strong>N° Proforma:</strong> {{ str_pad($orden['proforma']['idproforma'], 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Responsable Principal:</strong> {{ ucwords(strtolower($orden['responsable'])) }}</p>
            <p><strong>Ejecutivo de Cuenta:</strong> {{ ucwords(strtolower($orden['proforma']['usuario']['nombre'])) }}
                {{ ucwords(strtolower($orden['proforma']['usuario']['apellido'])) }}</p>
            <p><strong>Prioridad:</strong> {{ $orden['prioridad'] }}</p>

            @if ($orden['aprobada'] && $orden['usuarioAprueba'] && !empty($orden['usuarioAprueba']))
                <p><strong>Aprobada por:</strong>
                    {{ ucwords(strtolower($orden['usuarioAprueba']['nombre'] ?? '')) }}
                    {{ ucwords(strtolower($orden['usuarioAprueba']['apellido'] ?? '')) }}
                </p>
                <p><strong>Fecha aprobación:</strong> {{ $orden['fecha_aprobacion'] }}</p>
            @endif

        </div>
    </div>

    <!-- Sección detalles de servicios -->
    <div class="section">
        <h2>Servicios / Actividades</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Actividad</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Tiempo Estimado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orden['detalles'] as $index => $detalle)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ ucfirst(strtolower($detalle['descripcion'])) }}</td>
                        <td style="text-align: center;">{{ number_format($detalle['cantidad'], 2) }}</td>
                        <td>{{ $detalle['observaciones'] }}</td>
                        <td style="text-align: center;">{{ $detalle['estado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Sección responsables -->
    <div class="section avoid-break">
        <h2>Colaborades Asignados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tiempo asignado</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orden['responsables'] as $index => $responsable)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>
                            {{ ucwords(strtolower($responsable['nombre'])) }}
                            {{ ucwords(strtolower($responsable['apellido'])) }}
                        </td>
                        @php
                            $time = $responsable['pivot']['tiempo_asignado'];
                            $time = substr($time, 0, 15); // recorta para evitar errores
                        @endphp
                        <td style="text-align: center;">
                            {{ $time ? \Carbon\Carbon::createFromFormat('H:i:s.u', $time)->format('H:i:s') : '-' }}
                        </td>

                        <td>{{ $responsable['pivot']['observaciones'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Sección tiempo estimado -->
    <div class="section avoid-break" style="margin-top: 40px">
        <!--<h2>Servicios Detallados</h2> -->
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3">Tiempo estimado de entrega en horas:</th>
                    <th>Días:</th>
                    <th>Empieza:</th>
                    <th>Termina:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align: center;">{{ $orden['proforma']['horasEstimadas'] }}</td>
                    <td style="min-width: 60px; text-align: center;">0</td>
                    <td style="min-width: 65px; text-align: center;">{{ $orden['proforma']['fechaEstimadaInicio'] }}
                    </td>
                    <td style="min-width: 65px; text-align: center;">
                        {{ $orden['proforma']['fechaEstimadaFinalizacion'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Sección Comentario -->
    <div class="section-totales avoid-break">
        @if (!empty($orden['comentario']))
            <h2>Comentario</h2>
            <div style="font-size: 14px; padding: 0px 15px;">
                <p>{{ ucfirst(strtolower($orden['comentario'])) }}</p>
            </div>
            <div style="border-bottom: 1px solid #ddd; margin: 20px auto 2px;"></div>
            <div style="font-size: 10px;"><strong>NOTA:</strong> Por favor, realizar este trabajo con extrema precaución
                y responsabilidad. Cada tarea debe llevarse a cabo con dedicación y atención al detalle, asegurando un
                resultado final óptimo y sin errores.</div>
            <div style="border-bottom: 1px solid #ddd; margin: 2px auto;"></div>
            <div style="border-bottom: 1px solid #ddd; margin: 1px auto;"></div>
        @endif
    </div>
    </div>


    <!-- Footer -->
    <div class="footer">
        Gracias por confiar en nosotros. Esta orden no representa un documento tributario oficial.<br>
        Emitido por CRIPADA S.A. - {{ $orden['created_at'] ?? '' }}
    </div>
</body>

</html>
