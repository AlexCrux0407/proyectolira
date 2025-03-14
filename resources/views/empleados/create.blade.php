@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="mb-0">
                        <i class="bi bi-person-plus-fill text-primary me-2"></i>Nuevo Empleado
                    </h2>
                    <p class="text-muted">Complete el formulario para registrar un nuevo empleado</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('empleados.index') }}">Empleados</a></li>
                        <li class="breadcrumb-item active">Nuevo Empleado</li>
                    </ol>
                </nav>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('empleados.store') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                @error('nombre')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                                @error('apellidos')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="sucursal_id" class="form-label fw-semibold">Sucursal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                                <select class="form-select" id="sucursal_id" name="sucursal_id" required>
                                    <option value="">Seleccione una sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" {{ isset($sucursal_id) && $sucursal_id == $sucursal->id ? 'selected' : '' }}>
                                            {{ $sucursal->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('sucursal_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="puesto" class="form-label fw-semibold">Puesto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-briefcase"></i></span>
                                <input type="text" class="form-control" id="puesto" name="puesto" required>
                            </div>
                            @error('puesto')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="fecha_contratacion" class="form-label fw-semibold">Fecha de Contratación</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-calendar"></i></span>
                                    <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion">
                                </div>
                                @error('fecha_contratacion')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="salario" class="form-label fw-semibold">Salario</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-currency-dollar"></i></span>
                                    <input type="number" step="0.01" min="0" class="form-control" id="salario" name="salario" placeholder="0.00">
                                </div>
                                @error('salario')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="(XXX) XXX-XXXX">
                                </div>
                                @error('telefono')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if(isset($sucursal_id))
                            <input type="hidden" name="from_sucursal" value="1">
                        @endif

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            @if(isset($sucursal_id))
                                <a href="{{ route('sucursales.show', $sucursal_id) }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                            @else
                                <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <div class="card border-0 bg-light shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-2"><i class="bi bi-info-circle me-2"></i>Información Importante</h6>
                        <ul class="small mb-0">
                            <li>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</li>
                            <li>El correo electrónico debe ser único para cada empleado.</li>
                            <li>Se recomienda ingresar un número de teléfono para contacto de emergencias.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .input-group-text {
        border: none;
    }
</style>
@endsection

@section('scripts')
<script>
    // Formato de teléfono
    document.getElementById('telefono').addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });
</script>
@endsection