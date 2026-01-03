<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Mensual - {{ $mes->nombre }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #6dacd6; padding-bottom: 10px; margin-bottom: 20px; }
        .empresa-nombre { color: #6dacd6; font-size: 24px; font-weight: bold; margin: 0; }
        .servicio-section { margin-bottom: 30px; page-break-inside: avoid; }
        .servicio-title { background: #f4f4f4; padding: 10px; border-left: 5px solid #6dacd6; font-size: 16px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #6dacd6; color: white; text-align: left; padding: 8px; font-size: 12px; }
        td { border: 1px solid #eee; padding: 8px; font-size: 11px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>
    <div class="header">
        <p class="empresa-nombre">{{ $empresa->nombre }}</p>
        <p>Reporte Mensual de Actividades: <strong>{{ $mes->nombre }}</strong></p>
    </div>

    @foreach($servicios as $servicio)
        <div class="servicio-section">
            <div class="servicio-title">
                <strong>Servicio:</strong> {{ $servicio->nombre }} 
                <span style="float: right; font-size: 12px;">Fecha: {{ $servicio->fecha ?? 'N/A' }}</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="15%">Hora</th>
                        <th width="35%">Actividad / Plaga</th>
                        <th width="20%">Área</th>
                        <th width="30%">Técnico Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicio->actividades as $actividad)
                        <tr>
                            <td>{{ $actividad->hora }}</td>
                            <td>{{ $actividad->nombre }}</td>
                            <td>{{ $actividad->area ?? 'General' }}</td>
                            <td>{{ $actividad->relTecnico1->nombre ?? 'Sin asignar' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">No se registraron actividades en este servicio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        Generado automáticamente - {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>