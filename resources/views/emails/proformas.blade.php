<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proforma Adjunta</title>
</head>

<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, sans-serif;">
    <table align="center" width="600" cellpadding="0" cellspacing="0"
        style="background-color:#ffffff; border-radius:12px; box-shadow:0 0 8px rgba(0,0,0,0.05); overflow:hidden;">
        <tr>
            <td style="padding:20px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <!-- Texto a la izquierda -->
                        <td width="60%" valign="top" style="padding-right:20px;">
                            <h2 style="color:#1e3a8a; font-size:20px; margin:0 0 12px;">Proforma enviada a
                                {{ $cliente }}</h2>
                            <p style="font-size:14px; line-height:1.6; color:#374151;">
                                Nos complace enviarle la proforma correspondiente a su solicitud. Puede revisarla en el
                                documento PDF adjunto.<br><br>
                                Si está de acuerdo con los términos y valores, puede aprobarla directamente desde este
                                mensaje.
                            </p>
                            <a href="http://127.0.0.1:8000/proformas/aprobar/{{ $proforma->idproforma }}"
                                style="
                                    display: inline-block;
                                    margin-top: 16px;
                                    padding: 12px 24px;
                                    background-color: #22c55e;
                                    color: #ffffff;
                                    text-decoration: none;
                                    font-weight: bold;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
                                    transition: background-color 0.3s, box-shadow 0.3s;
                                "
                                onmouseover="this.style.backgroundColor='#16a34a'; this.style.boxShadow='0 6px 18px rgba(22, 163, 74, 0.5)'"
                                onmouseout="this.style.backgroundColor='#22c55e'; this.style.boxShadow='0 4px 12px rgba(34, 197, 94, 0.4)'">
                                Aprobar Proforma
                            </a>

                        </td>

                        <!-- Logo a la derecha -->
                        <td width="40%" align="center" valign="middle">
                            <img src="https://cripada.com/wp-content/uploads/2023/05/Cripada_logo1-1024x285.png"
                                alt="Logo CRIPADA" width="140" style="max-width:100%; margin-top:10px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding:16px; background-color:#f9fafb; text-align:center; font-size:12px; color:#6b7280;">
                © 2025 CRIPADA S.A. – Logística y Distribución<br>
                Este mensaje ha sido generado automáticamente. Por favor, no responda a este correo.
            </td>
        </tr>
    </table>
</body>

</html>
