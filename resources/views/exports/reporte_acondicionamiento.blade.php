<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate" />
    <title>REPORTE DE SERVICIOS</title>

    <style>
        table {
            border-collapse: collapse;
        }

        thead th {
            border: 2px solid black;
            /* borde grueso */
            padding: 5px;
            text-align: center;
        }

        tbody td {
            border: 1px solid rgb(250, 250, 250);
            padding: 1px 10px;
        }

        .tabla-info td {
            padding: 5px;
            font-family: Calibri, sans-serif;
            font-size: 14px;
        }
    </style>
</head>

<body translate="no">
    <div style="margin: 40px auto 150px auto; font-family:Calibri, sans-serif;">
        <table class="tabla-info" border="1" style="margin-left:40px;">
            <tr>
                <td colspan="7"></td>
                <td colspan="3" rowspan="4">
                    <img src="https://cripada.com/wp-content/uploads/2023/05/Cripada_logo1-1024x285.png" alt="Logo"
                        width="240" height="100">
                </td>
            </tr>
            <tr>
                <td><strong></strong></td>
                <td></td>
                <td><strong></strong></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"><strong>SERVICIO DE ACONDICIONAMIENTO, HORAS EXTRAS Y ESTIBA</strong></td>
            </tr>
            <tr>
                <td colspan="4"><strong>TOTAL GENERAL: $ {{ number_format($totalGeneral, 2) }}</strong></td>
            </tr>
        </table>

        <br>

        <table style="margin-left:auto; margin-right:auto;">
            <thead>
                <tr>
                    <th colspan="10">
                        REPORTE DE SERVICIOS DE ACONDICIONAMIENTO HORAS EXTRAS Y ESTIBA - {{$nomSede}} - {{$nomCliente}}
                    </th>
                </tr>
                <tr>
                    <th>N° OT</th>
                    <th>F. INICIO</th>
                    <th>F. FIN</th>
                    <th>AUTORIZADO POR</th>
                    <th>SERVICIO</th>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO UND.</th>
                    <th>VALOR URGENTES</th>
                    <th>PRECIO TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proformasAgrupadas as $idproforma => $detalles)
                    <tr>
                        <td colspan="10" style="background:#DCE6F1;">
                            <strong>PROFORMA N° {{ $detalles[0]->num_proforma }}</strong>
                        </td>
                    </tr>

                    @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->num_ot }}</td>
                            <td>{{ $detalle->fecha_inicio ?? '-' }}</td>
                            <td>{{ $detalle->fecha_fin ?? '-' }}</td>
                            <td>{{ $detalles[0]->solicitante ?? '-' }}</td>
                            <td>{{ $detalle->servicio_nombre ?? '-' }}</td>
                            <td>{{ $detalle->detalle_descripcion ?? '-' }}</td>
                            <td style="text-align:center;">{{ $detalle->cantidad }}</td>
                            <td style="text-align:center;">$ {{ number_format($detalle->precio, 2) }}</td>
                            <td style="text-align:center;">$ 0,00</td>
                            <td style="text-align:center;">$
                                {{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="9" style="text-align:right; background:#F0F3FA; color:#366092;">
                            <strong>TOTAL:</strong>
                        </td>
                        <td style="text-align:center; background:#F0F3FA; color:#366092;">
                            <strong>$ {{ number_format(collect($detalles)->sum('precio_total'), 2) }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
