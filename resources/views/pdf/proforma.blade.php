<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Documento de Proforma N.º {{ str_pad($proforma['idproforma'], 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        {!! file_get_contents(public_path('css/estilo_proforma.css')) !!}
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
                <div class="tagline">"Siempre es un placer brindarles un servicio de calidad."</div>
            </div>
            <div class="header-right">
                <div class="invoice-label">PROFORMA</div>
                <div class="invoice-info">
                    <strong>Fecha:</strong> {{ $proforma['fechaEmision'] }}<br>
                    @if (isset($proforma['numeroActualizado']) && $proforma['numeroActualizado'] != '0')
                        <strong>N.º Proforma {{ str_pad($proforma['numeroActualizado'], 6, '0', STR_PAD_LEFT) }}
                            actualizada al
                    @endif
                    </strong><strong>N.º Proforma:</strong>
                    <div class="nproforma">
                        {{ str_pad($proforma['idproforma'], 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección datos del cliente -->
    <div class="section">
        <h2>Datos del Cliente</h2>
        <div class="info">
            <p><strong>Nombre Comercial:</strong> {{ $proforma['cliente']['nombre_comercial'] }}</p>
            <p><strong>RUC/Cédula:</strong> {{ $proforma['cliente']['ruc_cedula'] }}</p>
            <p><strong>Dirección:</strong> {{ $proforma['cliente']['direccion'] }}</p>
            <p><strong>Teléfono:</strong> {{ $proforma['cliente']['telefono'] }}</p>
            <p><strong>Email:</strong> {{ $proforma['cliente']['email'] }}</p>
            <p><strong>Solicitado por:</strong> {{ $proforma['solicitante'] }}</p>
            <br>
            <p><strong>Ejecutivo/a de cuenta:</strong> {{ $proforma['usuario']['nombre'] }} {{ $proforma['usuario']['apellido'] }}</p>
        </div>
    </div>

    <!-- Sección detalle servicios -->
    <div class="section">
        <h2>Servicios</h2>
        @php
            $subtotal = 0;
            $valorurgente = 0;
        @endphp

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proforma['detalles'] as $index => $detalle)
                    @php
                        $precio = $detalle['precio'] ?? 0;
                        $cantidad = $detalle['cantidad'] ?? 0;
                        $subtotal += $precio * $cantidad;
                        if ($detalle['urgente']) {
                            $valorurgente += $precio * $cantidad * $porcentajeUrgente;
                        }
                    @endphp
                    <tr>
                        <td style="min-width: 20px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="min-width: 225px; font-size: 10px;">{{ $detalle['servicio']['nombre'] }}</td>
                        <td style="min-width: 225px; font-size: 10px;">{{ $detalle['descripcion'] }}</td>
                        <td style="min-width: 60px; text-align: center;">{{ $cantidad }}</td>
                        <td style="min-width: 65px; text-align: center;">$ {{ number_format($precio, 2) }}</td>
                        <td style="min-width: 65px; text-align: center;">${{ number_format($cantidad * $precio, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Sección Totales -->
    <div class="avoid-break">
        @php
            $iva = ($subtotal + $valorurgente) * $porcentajeIva;
            $total = $subtotal + $valorurgente + $iva;
        @endphp
        <div class="totales-box">
            <table>
                <tr>
                    <td style="width: 105px; font-size:12px"><strong>Suma Subtotal: </strong></td>
                    <td style="width: 80px; text-align: right; font-size:12px">$ {{ number_format($subtotal, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 105px; font-size:12px"><strong>Valor por urgente: </strong></td>
                    <td style="width: 80px; text-align: right; font-size:12px">$ {{ number_format($valorurgente, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 105px; font-size:12px"><strong>IVA %: </strong></td>
                    <td style="width: 80px; text-align: right; font-size:12px">$ {{ number_format($iva, 2) }}</td>

                </tr>
            </table>
        </div>
        <div class="totales-box" style="width: 177px; padding: 0px 17px; background-color: #f39c12;">
            <p class="font-size: 24px; "><strong>Total: $ {{ number_format($total, 2) }}</strong></p>
        </div>
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
                    <td colspan="3" style="text-align: center;">{{ $proforma['horasEstimadas'] }}</td>
                    <td style="min-width: 60px; text-align: center;">{{ $dias }}</td>
                    <td style="min-width: 65px; text-align: center;">{{ $proforma['fechaEstimadaInicio'] }}</td>
                    <td style="min-width: 65px; text-align: center;">{{ $proforma['fechaEstimadaFinalizacion'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Sección Tipo de Facturación -->
    <div class="section-totales avoid-break">
        @if (!empty($proforma['tipo_facturacion']['nombre']))
            <h2>Tipo de Facturación::</h2>
            <div class="info">
                {{ $proforma['tipo_facturacion']['nombre'] }}
            </div>
        @endif
    </div>

    <!-- Sección Comentario -->
    <div class="section-totales avoid-break">
        @if (!empty($proforma['comentario']))
            <h2>Comentario</h2>
            <div style="font-size: 14px; padding: 0px 15px;">
                {{ $proforma['comentario'] }}
            </div>
            <div style="border-bottom: 1px solid #ddd; margin: 20px auto 2px;"></div>
            <div style="font-size: 10px;"><strong>NOTA:</strong> LA FECHA DE INICIO Y
                TERMINACION DEL TRABAJO VARIARA SEGÚN LA FECHA DE APROBACIÓN.</div>
            <div style="border-bottom: 1px solid #ddd; margin: 2px auto;"></div>
            <div style="border-bottom: 1px solid #ddd; margin: 1px auto;"></div>
        @endif
    </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Gracias por confiar en nosotros. Esta proforma no representa una factura oficial.<br>
        Emitido por CRIPADA S.A. - {{ $proforma['created_at'] ?? '' }}
    </div>
</body>

</html>
