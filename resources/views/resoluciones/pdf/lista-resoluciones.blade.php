<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Resoluciones</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf/resoluciones/listapdf.css') }}">
</head>

<body>
    <div class="container">
        <!-- Cabecera -->
        <div class="header">
            <img src="{{ public_path('img/cbvp-logo-png.png') }}" alt="Logo CBVP">
            <h1>Cuerpo De Bomberos Voluntarios Del Paraguay</h1>
            <p>info@cbvp.org.py | www.bomberoscbvp.org.py</p>
            <p>Secretaría Nacional</p>
            <p>Cruz del Defensor 937 c/ Dr. Emilio Hassler</p>
        </div>

        <!-- Datos del Personal -->
        <div class="section">
            <h2>Listado de Resoluciones desde {{ date('d/m/Y', strtotime($fecha_desde ?? 'N/A')) }} Hasta {{ date('d/m/Y', strtotime($fecha_hasta ?? 'N/A')) }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>N° Resolución:</th>
                        <th>N° Acta:</th>
                        <th>Concepto:</th>
                        <th>Fecha:</th>
                        <th>Tipo:</th>
                        <th>Origen:</th>
                        <th></th>
                    </tr>
                </thead>
                @forelse ($resoluciones as $resolucion)
                    <tr>
                        <td>{{ $resolucion->n_resolucion ?? 'N/A' }}</td>
                        <td>{{ $resolucion->nro_acta ?? 'N/A' }}</td>
                        <td>{{ strlen($resolucion->concepto ?? 'N/A') > 40 ? substr($resolucion->concepto ?? 'N/A', 0, 40) . '...' : $resolucion->concepto ?? 'N/A' }}</td>
                        <td>{{ date('d/m/Y', strtotime($resolucion->fecha ?? 'N/A')) }}</td>
                        <td>{{ $resolucion->tipo_documento ?? 'N/A' }}</td>
                        <td>{{ $resolucion->fuente_origen ?? 'N/A' }}</td>
                        <td><a href="{{ route('descargar.resolucion', $resolucion->id_resolucion) }}" style="text-decoration: none; color: inherit;">Ver</a></td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align: center; font-style: italic;">No Se Registran Datos...</td>
                    </tr>
                @endforelse

            </table>
        </div>
    </div>
</body>

</html>
