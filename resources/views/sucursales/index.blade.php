@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Sucursales</h1>
        <div>
            <a href="{{ route('exportar.finanzas') }}" class="btn btn-success me-2">
                <i class="bi bi-file-excel"></i> Exportar Finanzas
            </a>
            <a href="{{ route('sucursales.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Sucursal
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    @if(isset($sucursales) && count($sucursales) > 0)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach($sucursales as $sucursal)
        <div class="col">
            <div class="card h-100 shadow-sm hover-card border-0">
                <div class="position-relative">
                    <img src="{{ asset('images/restaurant.png') }}" alt="Sucursal" class="card-img-top p-3" style="height: 180px; object-fit: contain;">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-primary rounded-pill">{{ $sucursal->empleados->count() }} empleados</span>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">{{ $sucursal->nombre }}</h5>
                    <p class="card-text text-muted small">ID: {{ $sucursal->id }}</p>
                    <hr>
                    <div class="d-grid">
                        <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye me-1"></i> Ver detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info">
        <p class="mb-0"><i class="bi bi-info-circle me-2"></i> No hay sucursales registradas. ¡Crea una nueva sucursal para comenzar!</p>
    </div>
    @endif
</div>

<!-- Modal para filtrar exportación -->
<div class="modal fade" id="exportarFinanzasModal" tabindex="-1" aria-labelledby="exportarFinanzasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportarFinanzasModalLabel">Exportar Reporte Financiero</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('exportar.finanzas') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ now()->subMonths(3)->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Exportar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('head')
<style>
    .hover-card {
        transition: transform 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" defer></script><script>
    let map;
    let markers = [];
    
    function initMap() {
        // Coordenadas de México como centro predeterminado
        const centerCoords = {lat: 19.4326, lng: -99.1332};
        
        map = new google.maps.Map(document.getElementById("map"), {
            center: centerCoords,
            zoom: 6, // Zoom para ver varias ciudades de México
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            streetViewControl: false,
            fullscreenControl: true,
        });
        
        // Añadir marcadores para cada sucursal
        @foreach($sucursales as $sucursal)
            @if(isset($sucursal->latitud) && isset($sucursal->longitud))
                addMarker({
                    lat: {{ $sucursal->latitud }}, 
                    lng: {{ $sucursal->longitud }}
                }, "{{ $sucursal->nombre }}", {{ $sucursal->id }});
            @endif
        @endforeach
        
        // Si no hay coordenadas específicas, use el geocoding para encontrar ubicaciones basadas en direcciones
        @foreach($sucursales as $sucursal)
            @if(!isset($sucursal->latitud) || !isset($sucursal->longitud))
                // Simulando ubicaciones para efectos de demostración
                // En producción, usaría el servicio de Geocoding de Google
                addMarker({
                    lat: 19.4326 + (Math.random() * 0.1 - 0.05), 
                    lng: -99.1332 + (Math.random() * 0.1 - 0.05)
                }, "{{ $sucursal->nombre }}", {{ $sucursal->id }});
            @endif
        @endforeach
        
        // Ajustar el mapa para mostrar todos los marcadores
        if (markers.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            for (let marker of markers) {
                bounds.extend(marker.getPosition());
            }
            map.fitBounds(bounds);
            
            // Asegúrese de que el zoom no sea demasiado cercano
            google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                if (map.getZoom() > 15) {
                    map.setZoom(15);
                }
            });
        }
    }
    
    function addMarker(position, title, id) {
        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            animation: google.maps.Animation.DROP
        });
        
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="min-width: 200px;">
                    <h5 style="margin-bottom: 5px;">${title}</h5>
                    <p style="margin-bottom: 5px;">ID: ${id}</p>
                    <a href="/web/sucursales/${id}" class="btn btn-sm btn-primary">Ver detalles</a>
                </div>
            `
        });
        
        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
        
        markers.push(marker);
    }
</script>
@endsection