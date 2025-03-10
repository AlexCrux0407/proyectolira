<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Cambios - {{ $sucursal->nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .badge {
            display: inline-block;
            padding: 3px 7px;
            font-size: 10px;
            border-radius: 3px;
            color: white;
        }
        .bg-success {
            background-color: #28a745;
        }
        .bg-warning {
            background-color: #ffc107;
            color: black;
        }
        .bg-danger {
            background-color: #dc3545;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Historial de Cambios - Sucursal: {{ $sucursal->nombre }}</h1>
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Acción</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @if(count($todosCambios) > 0)
                @foreach($todosCambios as $cambio)
                    <tr>
                        <td>{{ $cambio->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            @if($cambio->modelo_tipo == 'App\Models\Sucursal')
                                Sucursal
                            @elseif($cambio->modelo_tipo == 'App\Models\Empleado')
                                Empleado
                            @else
                                {{ class_basename($cambio->modelo_tipo) }}
                            @endif
                        </td>
                        <td>
                            @if($cambio->accion == 'crear')
                                <span class="badge bg-success">Creación</span>
                            @elseif($cambio->accion == 'actualizar')
                                <span class="badge bg-warning">Actualización</span>
                            @elseif($cambio->accion == 'eliminar')
                                <span class="badge bg-danger">Eliminación</span>
                            @endif
                        </td>
                        <td>
                            @if($cambio->accion == 'crear')
                                Se creó un nuevo registro.
                            @elseif($cambio->accion == 'actualizar')
                                Campo <strong>{{ $cambio->campo }}</strong> cambió de 
                                <strong>"{{ $cambio->valor_anterior }}"</strong> a 
                                <strong>"{{ $cambio->valor_nuevo }}"</strong>
                            @elseif($cambio->accion == 'eliminar')
                                Se eliminó un registro.
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align:center;">No hay cambios registrados para esta sucursal.</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        <p>Reporte generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>