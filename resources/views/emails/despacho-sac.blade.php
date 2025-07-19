<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Notificación de Envío</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #10b981;
            --background-color: #f4f6f8;
            --card-bg: #ffffff;
            --text-color: #333333;
            --border-radius: 14px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 620px;
            margin: auto;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 35px 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .tag {
            display: inline-block;
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--accent-color);
            padding: 6px 14px;
            font-size: 0.85rem;
            border-radius: 9999px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .header {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .message {
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .footer {
            font-size: 0.85rem;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            text-align: center;
        }

        @media (max-width: 640px) {
            .container {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tag">Distribución diaria</div>
        <div class="header">Guías de despacho y camiones asignados</div>
        <div class="message">
            Estimados colaboradores, reciban un cordial saludo:<br><br>
            Se ha procedido con el envío de la planificación correspondiente a la jornada, la cual incluye el detalle de las guías de despacho emitidas, así como la asignación de los camiones destinados para llevar a cabo la distribución desde bodega. Para una revisión más detallada de la información, se adjunta el documento en formato PDF.<br><br>
            Agradecemos de antemano tu atención y quedamos atentos a cualquier consulta o comentario.
        </div>
        <div class="footer">
            © 2025 CRIPADA S.A. Logística y Distribución. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>


