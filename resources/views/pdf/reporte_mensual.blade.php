<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        
        /* Paginación dinámica */
        .footer-pagenum {
            position: fixed;
            bottom: -20px;
            right: 0px;
            font-size: 10px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-pagenum .pagenum:before {
            content: counter(page);
        }

        /* Estilos del Encabezado con Contacto */
        .header-table-top { width: 100%; border: none; margin-bottom: 20px; }
        .logo-img { width: 200px; height: auto; max-height: 80px; object-fit: contain; }
        .contact-text { text-align: right; vertical-align: middle; color: #1e40af; font-weight: bold; font-size: 11px; }

        /* Encabezado con datos del cliente */
        .header-table { width: 100%; border: none; margin-bottom: 40px; }
        .header-table td { vertical-align: top; border: none; padding: 0; }
        .label { font-weight: bold; color: #444; }
        .value { color: #333; font-weight: bold; } /* Naranja eliminado */

        /* Títulos */
        .asunto { text-align: center; color: #1e40af; font-size: 16px; font-weight: bold; margin-bottom: 30px; text-transform: uppercase; }
        .cert-title { text-align: center; color: #1e40af; font-size: 18px; font-weight: bold; margin: 40px 0; text-transform: uppercase; }

        /* Cuerpo de texto */
        .content { text-align: justify; margin-bottom: 20px; font-size: 13px; }
        .highlight { color: #1e40af; font-weight: bold; } /* Naranja cambiado al azul de la paleta */

        /* Pie de página de la portada */
        .footer-info { margin-top: 50px; font-weight: bold; }
        .folio { margin-top: 10px; color: #666; font-size: 11px; }

        .firmas-container { width: 100%; text-align: center; padding: 20px 0; position: relative; top: 70px; }
        .firmas-dueno-img { width: 400px; height: 150px; display: inline-block; }

        /* Tablas y evidencias del servicio */
        .service-header { border-bottom: 1px solid #1e40af; margin-top: 20px; padding-bottom: 5px; color: #1e40af; }
        .table-activities { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .table-activities th { background-color: #f8fafc; color: #1e40af; font-size: 10px; text-transform: uppercase; padding: 8px; border: 1px solid #dee2e6; }
        .table-activities td { border: 1px solid #dee2e6; padding: 6px; font-size: 10px; vertical-align: middle; }
        
        .photo-grid { width: 100%; margin-top: 10px; }
        .photo-item { display: inline-block; width: 30%; margin-right: 2%; margin-bottom: 10px; text-align: center; }
        .activity-img { width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        
        .list-section { margin-top: 15px; font-size: 11px; }
        .sig-mini { height: 30px; filter: grayscale(1); }
        .observation-box { margin-top: 10px; padding: 10px; border: 1px solid #dee2e6; background-color: #fcfcfc; font-size: 10px; text-align: justify; }
        
        /* Ajuste de imágenes anexas para evitar saltos de página en blanco */
        .perimeter-section { margin-top: 20px; text-align: center; }
        .anexo-img { width: 100%; max-height: 800px; object-fit: contain; margin-top: 10px; } 
        .service-date-header { font-size: 14px; color: #1e40af; border-bottom: 2px solid #1e40af; margin-bottom: 10px; padding-bottom: 5px; }
        
        .page-break { page-break-after: always; }
        .section-title-anexo { text-align: center; color: #1e40af; font-size: 16px; font-weight: bold; margin-bottom: 10px; }

        /* --- NUEVO DISEÑO EDITORIAL: RECOMENDACIONES Y PROTOCOLOS --- */
        .recom-title { 
            font-size: 20px; 
            color: #1e40af; 
            margin-bottom: 15px; 
            margin-top: 20px; 
            text-transform: uppercase; 
            border-bottom: 2px solid #1e40af; 
            padding-bottom: 10px;
        }
        .recom-intro { font-size: 13px; color: #444; margin-bottom: 25px; text-align: justify; }
        
        /* Estilo tipo "Tarjeta" */
        .recom-card {
            background-color: #f4f7fb; /* Azul muy tenue */
            border-left: 4px solid #1e40af; /* Línea decorativa izquierda */
            padding: 12px 18px;
            margin-bottom: 15px;
            border-radius: 0 6px 6px 0;
        }
        .recom-card-title {
            font-size: 13px;
            color: #1e40af;
            font-weight: bold;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .recom-card-text {
            font-size: 12px;
            color: #333;
            text-align: justify;
            line-height: 1.5;
        }

    </style>
</head>
<body>

    <div class="footer-pagenum">
        Página <span class="pagenum"></span>
    </div>

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

    {{-- BUCLE DE SERVICIOS --}}
    @foreach($mes->servicios as $servicio)
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
                    <li>{{ $producto->nombre }} - {{ $producto->concentracion }}</li>
                @endforeach
            </ul>

            <p><span class="label">TÉCNICOS QUE REALIZARON EL SERVICIO:</span></p>
            <ul style="margin-top: -5px;">
                @foreach($servicio->tecnicos as $tecnico)
                    <li>{{ $tecnico->nombre }} {{ $tecnico->apeido_P }} {{ $tecnico->apeido_M }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach

    {{-- SECCIÓN DE ANEXOS TÉCNICOS --}}

    {{-- 1. Esquemas de la Empresa --}}
    @if(isset($esquemas) && count($esquemas) > 0)
        @foreach($esquemas as $index => $imgBase64)
            <div class="page-break"></div>
            <div class="perimeter-section">
                <div class="section-title-anexo">ANEXO TÉCNICO: ESQUEMAS Y PLANOS DE LA EMPRESA (Pág. {{ $index + 1 }})</div>
                <img src="{{ $imgBase64 }}" class="anexo-img">
            </div>
        @endforeach
    @endif

    {{-- SECCIÓN: RECOMENDACIONES (DISEÑO EDITORIAL) --}}
    <div class="page-break"></div>
    
    <div class="recom-title">
        Recomendaciones para el Control de Plagas
    </div>
    
    <div class="recom-intro">
        Para maximizar la efectividad residual del tratamiento, es obligatorio cumplir con las siguientes medidas de preparación antes del servicio:
    </div>

    <div class="recom-card">
        <div class="recom-card-title">1. Limpieza de superficies</div>
        <div class="recom-card-text">Realice un aseo profundo en zonas críticas (cocina, fregaderos y roperos). Eliminar la suciedad y grasa es indispensable para que el insecticida se adhiera correctamente a las paredes y superficies.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">2. Despeje de cocina y utensilios</div>
        <div class="recom-card-text">Vacíe gabinetes y alacenas. Limpie y guarde trastes, cubiertos y despensa en bolsas plásticas herméticas. Esto evita que las plagas se oculten en los objetos y permite que el producto penetre en sus refugios.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">3. Resguardo de alimentos</div>
        <div class="recom-card-text">Selle todo alimento abierto en recipientes herméticos. Deseche cualquier producto fresco que quede expuesto durante el proceso. Las frutas y verduras deben lavarse con agua y jabón antes de su consumo. Los productos enlatados no requieren protección.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">4. Protección electrónica</div>
        <div class="recom-card-text">Cubra computadoras, impresoras y laptops con fundas o bolsas plásticas para evitar que los componentes internos entren en contacto con la nebulización del servicio.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">5. Desalojo y seguridad</div>
        <div class="recom-card-text">Evacue a personas y mascotas por un mínimo de 2 horas. En caso de acuarios, notifique al técnico y cubra el tanque con un paño húmedo.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">6. Restricción de acceso</div>
        <div class="recom-card-text">Queda prohibido el ingreso a las áreas durante la aplicación. En caso de una entrada de emergencia, es obligatorio el uso de equipo de protección personal (EPP).</div>
    </div>

    {{-- SECCIÓN: PROTOCOLO POSTERIOR (DISEÑO EDITORIAL) --}}
    <div class="page-break"></div>

    <div class="recom-title">
        Protocolo posterior al servicio
    </div>

    <div class="recom-intro">
        Para garantizar su seguridad y la durabilidad del tratamiento, siga estrictamente los siguientes pasos tras la aplicación:
    </div>

    <div class="recom-card">
        <div class="recom-card-title">1. Ventilación de áreas</div>
        <div class="recom-card-text">Al concluir, abra puertas y ventanas. Permita la circulación del aire durante 30 minutos antes de reocupar los espacios.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">2. Conservación del efecto residual</div>
        <div class="recom-card-text">No limpie las superficies tratadas durante las primeras 24 horas; el contacto directo garantiza la eficacia del producto. Si observa zonas húmedas, extienda el tiempo de espera hasta que sequen por completo. Ante cualquier duda sobre alimentos expuestos, deséchelos.</div>
    </div>

    <div class="recom-card">
        <div class="recom-card-title">3. Recepción de documentación</div>
        <div class="recom-card-text">Solicite al técnico la ficha técnica detallada de los productos utilizados para su control y registro oficial.</div>
    </div>

    {{-- 2. Controles Perimetrales de los Servicios --}}
    @if(isset($perimetrales) && count($perimetrales) > 0)
        @foreach($perimetrales as $index => $imgBase64)
            <div class="page-break"></div>
            <div class="perimeter-section">
                <div class="section-title-anexo">ANEXO TÉCNICO: CONTROL PERIMETRAL DEL SERVICIO (Pág. {{ $index + 1 }})</div>
                <img src="{{ $imgBase64 }}" class="anexo-img">
            </div>
        @endforeach
    @endif

    {{-- 3. CARTEL INFORMATIVO --}}
    <div class="page-break"></div>
    <div class="perimeter-section">
        <div class="section-title-anexo">ANEXO: INFORMACIÓN GENERAL</div>
        <img src="{{ public_path('media/cartel.png') }}" class="anexo-img">
    </div>

    {{-- 4. Fichas Técnicas de Productos Utilizados --}}
    @if(isset($fichas) && count($fichas) > 0)
        @foreach($fichas as $index => $imgBase64)
            <div class="page-break"></div>
            <div class="perimeter-section">
                <div class="section-title-anexo">ANEXO TÉCNICO: FICHA TÉCNICA DE PRODUCTO (Pág. {{ $index + 1 }})</div>
                <img src="{{ $imgBase64 }}" class="anexo-img">
            </div>
        @endforeach
    @endif

    {{-- 5. LICENCIAS SANITARIAS --}}
    <div class="page-break"></div>
    <div class="perimeter-section">
        <div class="section-title-anexo">ANEXO: LICENCIA SANITARIA OFICIAL</div>
        <img src="{{ public_path('media/licencia sanitaria.png') }}" class="anexo-img">
    </div>

    <div class="page-break"></div>
    <div class="perimeter-section">
        <div class="section-title-anexo">ANEXO: LICENCIA SANITARIA OFICIAL (REVERSO)</div>
        <img src="{{ public_path('media/licencia sanitaria2.png') }}" class="anexo-img">
    </div>

    {{-- 6. CALENDARIO DE SERVICIOS DE LA EMPRESA --}}
    @if($empresa->calendario && $empresa->calendario !== 'fotos/profile.jpg')
        <div class="page-break"></div>
        <div class="perimeter-section">
            <div class="section-title-anexo">ANEXO: CALENDARIO DE SERVICIOS PROGRAMADOS</div>
            <img src="{{ public_path('storage/' . $empresa->calendario) }}" class="anexo-img">
        </div>
    @endif

</body>
</html>