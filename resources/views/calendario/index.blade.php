@extends('layouts.app')

@section('head')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<style>
  .fc-event {
    cursor: pointer;
  }
  
  .fc-day:hover {
    background-color: #f8f9fa;
    cursor: pointer;
  }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Calendario de Visitas de Proveedores</h2>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaVisitaModal">
        <i class="bi bi-plus-circle"></i> Programar Visita
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div id="calendario"></div>
    </div>
</div>

<!-- Modal para Nueva Visita -->
<div class="modal fade" id="nuevaVisitaModal" tabindex="-1" aria-labelledby="nuevaVisitaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevaVisitaModalLabel">Programar Visita de Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('calendario.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select class="form-control" id="proveedor_id" name="proveedor_id" required>
              <option value="">Seleccione un proveedor</option>
              @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre_empresa }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="sucursal_id" class="form-label">Sucursal</label>
            <select class="form-control" id="sucursal_id" name="sucursal_id" required>
              <option value="">Seleccione una sucursal</option>
              @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha_visita" class="form-label">Fecha de Visita</label>
            <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" required>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="hora_inicio" class="form-label">Hora de Inicio</label>
              <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
            </div>
            <div class="col-md-6">
              <label for="hora_fin" class="form-label">Hora de Fin</label>
              <input type="time" class="form-control" id="hora_fin" name="hora_fin">
            </div>
          </div>
          <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <input type="text" class="form-control" id="motivo" name="motivo">
          </div>
          <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" id="estado" name="estado" required>
              <option value="programada">Programada</option>
              <option value="completada">Completada</option>
              <option value="cancelada">Cancelada</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="notas" class="form-label">Notas</label>
            <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para Editar Visita -->
<div class="modal fade" id="editarVisitaModal" tabindex="-1" aria-labelledby="editarVisitaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarVisitaModalLabel">Editar Visita de Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editarVisitaForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_proveedor_id" class="form-label">Proveedor</label>
            <select class="form-control" id="edit_proveedor_id" name="proveedor_id" required>
              <option value="">Seleccione un proveedor</option>
              @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre_empresa }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_sucursal_id" class="form-label">Sucursal</label>
            <select class="form-control" id="edit_sucursal_id" name="sucursal_id" required>
              <option value="">Seleccione una sucursal</option>
              @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_fecha_visita" class="form-label">Fecha de Visita</label>
            <input type="date" class="form-control" id="edit_fecha_visita" name="fecha_visita" required>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_hora_inicio" class="form-label">Hora de Inicio</label>
              <input type="time" class="form-control" id="edit_hora_inicio" name="hora_inicio">
            </div>
            <div class="col-md-6">
              <label for="edit_hora_fin" class="form-label">Hora de Fin</label>
              <input type="time" class="form-control" id="edit_hora_fin" name="hora_fin">
            </div>
          </div>
          <div class="mb-3">
            <label for="edit_motivo" class="form-label">Motivo</label>
            <input type="text" class="form-control" id="edit_motivo" name="motivo">
          </div>
          <div class="mb-3">
            <label for="edit_estado" class="form-label">Estado</label>
            <select class="form-control" id="edit_estado" name="estado" required>
              <option value="programada">Programada</option>
              <option value="completada">Completada</option>
              <option value="cancelada">Cancelada</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_notas" class="form-label">Notas</label>
            <textarea class="form-control" id="edit_notas" name="notas" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btnEliminarVisita">Eliminar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
      <form id="eliminarVisitaForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/es.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendario');
    
    // Convertir los eventos PHP en formato JavaScript
    const eventos = @json($eventos);
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      events: eventos,
      editable: true,
      selectable: true,
      dayMaxEvents: true,
      
      // Al hacer clic en una fecha vacía
      dateClick: function(info) {
        // Limpiar el formulario
        document.getElementById('fecha_visita').value = info.dateStr;
        
        // Abrir modal de nueva visita
        const nuevaVisitaModal = new bootstrap.Modal(document.getElementById('nuevaVisitaModal'));
        nuevaVisitaModal.show();
      },
      
      // Al hacer clic en un evento existente
      eventClick: function(info) {
        const evento = info.event;
        const id = evento.id;
        const title = evento.title;
        
        // Split del título para obtener proveedor y sucursal (formato: "Proveedor - Sucursal")
        const partes = title.split(' - ');
        
        // Buscar el proveedor_id y sucursal_id basado en los nombres
        const proveedorNombre = partes[0];
        const sucursalNombre = partes[1];
        
        // Encontrar el selector adecuado
        const proveedorSelect = document.getElementById('edit_proveedor_id');
        const sucursalSelect = document.getElementById('edit_sucursal_id');
        
        // Seleccionar la opción correcta
        for (let i = 0; i < proveedorSelect.options.length; i++) {
          if (proveedorSelect.options[i].text === proveedorNombre) {
            proveedorSelect.selectedIndex = i;
            break;
          }
        }
        
        for (let i = 0; i < sucursalSelect.options.length; i++) {
          if (sucursalSelect.options[i].text === sucursalNombre) {
            sucursalSelect.selectedIndex = i;
            break;
          }
        }
        
        // Llenar el resto del formulario
        document.getElementById('edit_fecha_visita').value = evento.start ? evento.start.toISOString().split('T')[0] : '';
        
        if (evento.start) {
          const horaInicio = evento.start.toISOString().split('T')[1].substring(0, 5);
          document.getElementById('edit_hora_inicio').value = horaInicio;
        }
        
        if (evento.end) {
          const horaFin = evento.end.toISOString().split('T')[1].substring(0, 5);
          document.getElementById('edit_hora_fin').value = horaFin;
        }
        
        document.getElementById('edit_motivo').value = evento.extendedProps.description || '';
        document.getElementById('edit_estado').value = evento.extendedProps.estado || 'programada';
        document.getElementById('edit_notas').value = evento.extendedProps.notas || '';
        
        // Configurar el formulario para editar
        document.getElementById('editarVisitaForm').action = `/calendario/${id}`;
        
        // Configurar el formulario para eliminar
        document.getElementById('eliminarVisitaForm').action = `/calendario/${id}`;
        
        // Abrir modal de edición
        const editarVisitaModal = new bootstrap.Modal(document.getElementById('editarVisitaModal'));
        editarVisitaModal.show();
      },
      
      // Al arrastrar y soltar un evento
      eventDrop: function(info) {
        const evento = info.event;
        const id = evento.id;
        
        // Crear un formulario oculto para actualizar la fecha
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/calendario/${id}`;
        form.style.display = 'none';
        
        // Agregar los campos necesarios
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
        
        const fechaField = document.createElement('input');
        fechaField.type = 'hidden';
        fechaField.name = 'fecha_visita';
        fechaField.value = evento.start.toISOString().split('T')[0];
        form.appendChild(fechaField);
        
        // Mantener los valores existentes
        const campos = ['proveedor_id', 'sucursal_id', 'hora_inicio', 'hora_fin', 'motivo', 'estado', 'notas'];
        campos.forEach(campo => {
          const valor = evento.extendedProps[campo];
          if (valor) {
            const field = document.createElement('input');
            field.type = 'hidden';
            field.name = campo;
            field.value = valor;
            form.appendChild(field);
          }
        });
        
        // Enviar el formulario
        document.body.appendChild(form);
        form.submit();
      }
    });
    
    calendar.render();
    
    // Manejar el botón de eliminar
    document.getElementById('btnEliminarVisita').addEventListener('click', function() {
      if (confirm('¿Está seguro que desea eliminar esta visita?')) {
        document.getElementById('eliminarVisitaForm').submit();
      }
    });
  });
</script>
@endsection