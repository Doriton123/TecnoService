<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de Solicitudes - TecnoService</title>

    <style>
        @page {
            margin: 75px 30px 55px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #263238;
        }

        .header {
            position: fixed;
            top: -55px;
            left: 0;
            right: 0;
            border-bottom: 2px solid #1565c0;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 19px;
            color: #1565c0;
            margin: 0;
        }

        .header p {
            font-size: 10px;
            margin: 4px 0 0;
        }

        .footer {
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            border-top: 1px solid #cccccc;
            padding-top: 8px;
            font-size: 8px;
            color: #666666;
        }

        .fecha {
            text-align: right;
            margin-bottom: 15px;
        }

        .filtros {
            background: #eef4fb;
            padding: 10px;
            margin-bottom: 12px;
        }

        .resumen {
            margin-bottom: 15px;
        }

        .resumen table {
            width: 100%;
            border-collapse: collapse;
        }

        .resumen td {
            border: 1px solid #cccccc;
            padding: 8px;
            text-align: center;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tabla th {
            background: #1565c0;
            color: white;
            padding: 8px 5px;
            border: 1px solid #cccccc;
        }

        .tabla td {
            border: 1px solid #cccccc;
            padding: 7px 5px;
            vertical-align: top;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .tabla tbody tr:nth-child(even) {
            background: #f5f7fa;
        }

        .tabla tr {
            page-break-inside: avoid;
        }

        .estado {
            font-weight: bold;
        }

        .pendiente {
            color: #b7791f;
        }

        .proceso {
            color: #1565c0;
        }

        .finalizada {
            color: #16803c;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>TecnoService</h1>
        <p>Sistema de Gestión de Mantenimiento y Reparación de Equipos</p>
    </div>

    <div class="footer">
        Documento generado automáticamente por TecnoService.
    </div>

    <div class="fecha">
        <strong>Fecha de generación:</strong>
        {{ $fechaGeneracion->format('d/m/Y H:i:s') }}
    </div>

    <h2>Reporte de Solicitudes de Servicio</h2>

    <div class="filtros">
        <strong>Filtros aplicados:</strong>

        Estado:
        {{ $filtros['estado'] ?? 'Todos' }}

        &nbsp; | &nbsp;

        Desde:
        {{ !empty($filtros['fecha_inicio'])
    ? \Carbon\Carbon::parse($filtros['fecha_inicio'])->format('d/m/Y')
    : 'Sin límite' }}

        &nbsp; | &nbsp;

        Hasta:
        {{ !empty($filtros['fecha_fin'])
    ? \Carbon\Carbon::parse($filtros['fecha_fin'])->format('d/m/Y')
    : 'Sin límite' }}
    </div>

    <div class="resumen">
        <table>
            <tr>
                <td>
                    <strong>Total</strong>
                    <h2>{{ $resumen['total'] }}</h2>
                </td>
                <td>
                    <strong>Pendientes</strong>
                    <h2>{{ $resumen['pendientes'] }}</h2>
                </td>
                <td>
                    <strong>En proceso</strong>
                    <h2>{{ $resumen['en_proceso'] }}</h2>
                </td>
                <td>
                    <strong>Finalizadas</strong>
                    <h2>{{ $resumen['finalizadas'] }}</h2>
                </td>
            </tr>
        </table>
    </div>

    <table class="tabla">
        <thead>
            <tr>
                <th style="width: 12%;">Número</th>
                <th style="width: 16%;">Cliente</th>
                <th style="width: 16%;">Equipo</th>
                <th style="width: 11%;">Fecha recepción</th>
                <th style="width: 11%;">Servicio</th>
                <th style="width: 11%;">Estado</th>
                <th style="width: 23%;">Problema reportado</th>
            </tr>
        </thead>

        <tbody>
            @forelse($solicitudes as $solicitud)
                <tr>
                    <td>{{ $solicitud->numero_solicitud }}</td>

                    <td>
                        {{ $solicitud->cliente?->nombre_completo ?? 'No disponible' }}
                    </td>

                    <td>
                        {{ $solicitud->equipo?->tipo_equipo ?? '' }}
                        {{ $solicitud->equipo?->marca ?? '' }}
                        {{ $solicitud->equipo?->modelo ?? '' }}
                    </td>

                    <td>
                        {{ $solicitud->fecha_recepcion->format('d/m/Y') }}
                    </td>

                    <td>{{ $solicitud->tipo_servicio }}</td>

                    <td>
                        @php
                            $clase = match ($solicitud->estado) {
                                'Pendiente' => 'pendiente',
                                'En proceso' => 'proceso',
                                'Finalizada' => 'finalizada',
                                default => '',
                            };
                        @endphp

                        <span class="estado {{ $clase }}">
                            {{ $solicitud->estado }}
                        </span>
                    </td>

                    <td>{{ $solicitud->descripcion_problema }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">
                        No existen solicitudes con los filtros seleccionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont("DejaVu Sans", "normal");
            $pdf->page_text(
                720,
                565,
                "Página {PAGE_NUM} de {PAGE_COUNT}",
                $font,
                8,
                array(90, 90, 90)
            );
        }
    </script>

</body>

</html>