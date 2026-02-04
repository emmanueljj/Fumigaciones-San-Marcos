<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        
        /* Estilos del Encabezado con Contacto */
        .header-table-top { width: 100%; border: none; margin-bottom: 20px; }
        .logo-img { width: 200px; height: auto; max-height: 80px; object-fit: contain; }
        .contact-text { 
            text-align: right; 
            vertical-align: middle; 
            color: #1e40af; 
            font-weight: bold; 
            font-size: 11px; 
        }

        /* Encabezado con datos del cliente */
        .header-table { width: 100%; border: none; margin-bottom: 40px; }
        .header-table td { vertical-align: top; border: none; padding: 0; }
        .label { font-weight: bold; color: #444; }
        .value { color: #d97706; }

        /* Títulos */
        .asunto { text-align: center; color: #1e40af; font-size: 16px; font-weight: bold; margin-bottom: 30px; text-transform: uppercase; }
        .cert-title { text-align: center; color: #1e40af; font-size: 18px; font-weight: bold; margin: 40px 0; text-transform: uppercase; }

        /* Cuerpo de texto */
        .content { text-align: justify; margin-bottom: 20px; font-size: 13px; }
        .highlight { color: #d97706; font-weight: bold; }

        /* Pie de página y Folio */
        .footer-info { margin-top: 50px; font-weight: bold; }
        .folio { margin-top: 10px; color: #666; font-size: 11px; }

        .firmas-container {
            width: 100%;
            text-align: center;
            padding: 20px 0;
            position: relative;
            top: 70px;
        }

        .firmas-dueno-img {
            width: 400px;
            height: 150px;
            display: inline-block;
        }

        .service-header { 
            border-bottom: 1px solid #1e40af; 
            margin-top: 20px; 
            padding-bottom: 5px; 
            color: #1e40af; 
        }
        .table-activities { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 15px 0; 
        }
        .table-activities th { 
            background-color: #f8fafc; 
            color: #1e40af; 
            font-size: 10px; 
            text-transform: uppercase; 
            padding: 8px; 
            border: 1px solid #dee2e6; 
        }
        .table-activities td { 
            border: 1px solid #dee2e6; 
            padding: 6px; 
            font-size: 10px; 
            vertical-align: middle; 
        }
        .photo-grid { 
            width: 100%; 
            margin-top: 10px; 
        }
        .photo-item { 
            display: inline-block; 
            width: 30%; 
            margin-right: 2%; 
            margin-bottom: 10px; 
            text-align: center; 
        }
        .activity-img { 
            width: 100%; 
            height: 100px; 
            object-fit: cover; 
            border-radius: 8px; 
            border: 1px solid #ddd; 
        }
        .list-section { 
            margin-top: 15px; 
            font-size: 11px; 
        }
        .sig-mini { 
            height: 30px; 
            filter: grayscale(1); 
        }

        .observation-box {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #dee2e6;
            background-color: #fcfcfc;
            font-size: 10px;
            text-align: justify;
        }
        .perimeter-section {
            margin-top: 20px;
            text-align: center;
        }
        .perimeter-img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border: 1px solid #333;
            margin-top: 10px;
        }
        .service-date-header {
            font-size: 14px;
            color: #1e40af;
            border-bottom: 2px solid #1e40af;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <table class="header-table-top">
        <tr>
            <td width="50%">
                <img src="{{ public_path('media/logo.png') }}" class="logo-img">
            </td>
            <td width="50%" class="contact-text">
                01 462 622 0473 | fumsanmarcos@hotmail.com
            </td>
        </tr>
    </table>

    <table class="header-table">
        <tr>
            <td width="60%">
                <span class="label">ATENCIÓN A:</span> <span class="value">{{ $empresa->encargado }}</span><br>
                <span class="label">CARGO:</span> Mantenimiento
            </td>
            <td width="40%" style="text-align: right;">
                <span class="label">FECHA:</span> <span class="value">{{ \Carbon\Carbon::parse($mes->updated_at)->format('d/m/y') }}</span><br>
                <span class="label">LUGAR:</span> Irapuato, Gto. <span class="label">EMPRESA:</span> <span class="value">{{ $empresa->nombre }}</span>
            </td>
        </tr>
    </table>

    <div class="asunto">
        ASUNTO: Certificado Mensual de Control de Plagas - <span class="highlight">{{ $mes->nombre }}</span>
    </div>

    <div class="content">
        <p>Estimados señores,</p>
        <p>Por medio de la presente les envío un cordial saludo, esperando se encuentren muy bien. Aprovecho para informarles que, como parte de nuestro programa de Control General de Plagas, hemos acudido en el mes de 
            <span class="highlight">
                {{ \Carbon\Carbon::parse($mes->fecha_f)->locale('es')->translatedFormat('F') }}
            </span> a las instalaciones de <span class="highlight">{{ $empresa->nombre }}</span>.</p>
        <p>La finalidad de este reporte es determinar la incidencia de plagas en cada una de sus áreas y ajustar nuestras estrategias, técnicas y métodos para asegurar el resguardo de todas las áreas, equipo, maquinaria y productos presentes en sus instalaciones.</p>
    </div>

    <div class="cert-title">
        “CERTIFICADO CONTROL DE PLAGAS”
    </div>

    <div class="content">
        <p>EL QUE SUSCRIBE, <span style="font-weight: bold;">ING. ARMANDO CASTAÑEDA PEREZCHICA</span>, GERENTE DE LA EMPRESA DENOMINADA "FUMIGACIONES SAN MARCOS", EXTIENDE EL PRESENTE CERTIFICADO DE MANEJO Y CONTROL INTEGRADO DE PLAGAS A LA EMPRESA <span class="highlight">{{ $empresa->nombre }}</span> UBICADA EN <span class="highlight">{{ $empresa->ubicacion }}</span>.</p>
    </div>

    <div class="footer-info">
        <p>Se extiende el presente para los fines que al interesado convengan.<br>
        Este certificado prescribe a los 30 días. Irapuato, Gto. <span class="value">{{ \Carbon\Carbon::parse($mes->updated_at)->format('d/m/y') }}</span></p>
    </div>

    <div class="folio">
        Folio: ANT/{{ date('y') }}/{{ $mes->id_mes }}
    </div>

    <div class="firmas-container">
        <img src="{{ public_path('media/firmas.png') }}" class="firmas-dueno-img">
    </div>

    @foreach($servicios as $servicio)
        <div class="page-break"></div>

        <div class="service-date-header">
            <strong>SERVICIO REALIZADO EL: {{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}</strong>
        </div>

        <table class="table-activities">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Actividad</th>
                    <th>Hora</th>
                    <th>Área</th>
                    <th>V.B. Nombre</th>
                    <th>V.B. Firma</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicio->actividades as $index => $act)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $act->nombre }}</td>
                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($act->hora)->format('H:i') }}</td>
                        <td>{{ $act->area }}</td>
                        <td>{{ $act->vbNombre }}</td>
                        <td style="text-align: center;">
                            @if($act->vbFirma)
                                <img src="{{ public_path('storage/' . $act->vbFirma) }}" class="sig-mini">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="observation-box">
            <span class="label">OBSERVACIONES:</span><br>
            {{ $servicio->observacion ?? 'Sin observaciones particulares en este servicio.' }}
        </div>

        <div class="photo-grid">
            <p class="label">EVIDENCIAS FOTOGRÁFICAS:</p>
            @foreach($servicio->actividades as $act)
                @if($act->foto)
                    <div class="photo-item">
                        <img src="{{ public_path('storage/' . $act->foto) }}" class="activity-img">
                        <div style="font-size: 8px; color: #666;">{{ $act->nombre }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="list-section">
            <p><span class="label">PRODUCTOS UTILIZADOS:</span></p>
            <ul style="margin-top: -5px;">
                @foreach($servicio->productos as $producto)
                    <li>{{ $producto->nombre }} - {{ $producto->ingrediente_activo }}</li>
                @endforeach
            </ul>

            <p><span class="label">TÉCNICOS QUE REALIZARON EL SERVICIO:</span></p>
            <ul style="margin-top: -5px;">
                @foreach($servicio->tecnicos as $tecnico)
                    <li>{{ $tecnico->nombre }} {{ $tecnico->apeido_P }} {{ $tecnico->apeido_M }}</li>
                @endforeach
            </ul>
        </div>

        @if($servicio->controlPerimetral)
            <div class="perimeter-section" style="page-break-inside: avoid;">
                <p class="label">CONTROL PERIMETRAL Y LOCALIZACIÓN DE ESTACIONES:</p>
                
                @php
                    $extension = pathinfo($servicio->esquemas, PATHINFO_EXTENSION);
                @endphp

                @if(strtolower($extension) == 'pdf')
                    <div style="border: 1px dashed #1e40af; padding: 20px; color: #1e40af; text-align: center;">
                        <i class="fa-solid fa-file-pdf"></i><br>
                        El esquema está guardado como PDF.<br>
                        <small>Para visualizarlo dentro de este reporte, cámbialo a formato PNG o JPG.</small>
                    </div>
                @else
                    <img src="{{ public_path('storage/' . $servicio->esquemas) }}" class="perimeter-img">
                    <p style="font-size: 8px; color: #666;">Esquema técnico registrado para este servicio.</p>
                @endif
            </div>
        @endif
    @endforeach

</body>
</html>