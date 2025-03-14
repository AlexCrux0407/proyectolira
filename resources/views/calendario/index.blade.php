@extends('layouts.app')

@section('content')
  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-0">
      <i class="bi bi-calendar-check text-primary me-2"></i>
      Calendario de Visitas de Proveedores
      </h2>
      <p class="text-muted">Gestione las visitas de proveedores a sus sucursales</p>
    </div>
    <div>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaVisitaModal">
      <i class="bi bi-plus-circle me-1"></i> Programar Visita
      </button>
    </div>
    </div>

    <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <div class="calendar-toolbar bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <button id="btn-prev" class="btn btn-outline-secondary me-2">
        <i class="bi bi-chevron-left"></i>
        </button>
        <button id="btn-next" class="btn btn-outline-secondary me-3">
        <i class="bi bi-chevron-right"></i>
        </button>
        <button id="btn-today" class="btn btn-outline-primary me-3">Hoy</button>
        <h4 id="calendar-title" class="mb-0 fw-semibold">marzo de 2025</h4>
      </div>
      <div class="btn-group">
        <button id="btn-month" class="btn btn-secondary">Mes</button>
        <button id="btn-week" class="btn btn-outline-secondary">Semana</button>
        <button id="btn-day" class="btn btn-outline-secondary">Día</button>
        <button id="btn-agenda" class="btn btn-outline-secondary">Agenda</button>
      </div>
      </div>

      <div id="calendario"></div>
    </div>
    </div>

    <div class="row mt-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-light py-3">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Próximas Visitas</h5>
      </div>
      <div class="card-body">
        <div class="list-group list-group-flush">
        @if(isset($proximasVisitas) && count($proximasVisitas) > 0)
      @foreach($proximasVisitas as $visita)
      <div class="list-group-item border-0 border-bottom py-3 px-0">
      <div class="d-flex justify-content-between align-items-center">
      <div>
      <h6 class="mb-1">
      @if(isset($visita) && isset($visita->proveedor) && isset($visita->proveedor->nombre_empresa))
      {{ $visita->proveedor->nombre_empresa }}
    @else
      Proveedor no especificado
    @endif
      </h6>
      <p class="mb-0 small text-muted">
      @if(isset($visita) && isset($visita->sucursal) && isset($visita->sucursal->nombre))
      <i class="bi bi-building me-1"></i> {{ $visita->sucursal->nombre }}
    @else
      <i class="bi bi-building me-1"></i> Sucursal no especificada
    @endif

      <span class="mx-2">|</span>

      <i class="bi bi-clock me-1"></i>
      @if(isset($visita) && isset($visita->hora_inicio))
      {{ $visita->hora_inicio }}
    @else
      N/A
    @endif
      -
      @if(isset($visita) && isset($visita->hora_fin))
      {{ $visita->hora_fin }}
    @else
      N/A
    @endif
      </p>
      </div>
      <div>
      @if(isset($visita) && isset($visita->estado))
      @if($visita->estado == 'programada')
      <span class="badge bg-primary rounded-pill">Programada</span>
    @elseif($visita->estado == 'completada')
      <span class="badge bg-success rounded-pill">Completada</span>
    @elseif($visita->estado == 'cancelada')
      <span class="badge bg-danger rounded-pill">Cancelada</span>
    @else
      <span class="badge bg-secondary rounded-pill">{{ $visita->estado }}</span>
    @endif
    @else
      <span class="badge bg-secondary rounded-pill">Estado no definido</span>
    @endif
      </div>
      </div>
      </div>
    @endforeach
    @else
    <p class="text-center text-muted py-3">
      <i class="bi bi-calendar-x fs-4 d-block mb-2"></i>
      No hay visitas programadas próximamente
    </p>
  @endif
        </div>
      </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-light py-3">
        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Resumen de Visitas</h5>
      </div>
      <div class="card-body">
        <div class="row text-center">
        <div class="col-md-4 mb-3">
          <div class="p-3 rounded bg-primary bg-opacity-10">
          <h3 class="text-primary mb-0">{{ isset($totalProgramadas) ? $totalProgramadas : 0 }}</h3>
          <p class="small text-muted mb-0">Programadas</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="p-3 rounded bg-success bg-opacity-10">
          <h3 class="text-success mb-0">{{ isset($totalCompletadas) ? $totalCompletadas : 0 }}</h3>
          <p class="small text-muted mb-0">Completadas</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="p-3 rounded bg-danger bg-opacity-10">
          <h3 class="text-danger mb-0">{{ isset($totalCanceladas) ? $totalCanceladas : 0 }}</h3>
          <p class="small text-muted mb-0">Canceladas</p>
          </div>
        </div>
        </div>
        <div class="mt-4">
        <h6 class="mb-3">Proveedores más frecuentes</h6>
        <div class="table-responsive">
          <table class="table table-sm">
          <thead class="table-light">
            <tr>
            <th>Proveedor</th>
            <th>Visitas</th>
            <th>Última Visita</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($proveedoresFrecuentes) && count($proveedoresFrecuentes) > 0)
        @foreach($proveedoresFrecuentes as $proveedor)
      <tr>
      <td>{{ isset($proveedor->nombre_empresa) ? $proveedor->nombre_empresa : 'N/A' }}</td>
      <td>{{ isset($proveedor->total_visitas) ? $proveedor->total_visitas : 0 }}</td>
      <td>{{ isset($proveedor->ultima_visita) ? $proveedor->ultima_visita : 'N/A' }}</td>
      </tr>
    @endforeach
      @else
    <tr>
    <td colspan="3" class="text-center py-3">No hay datos disponibles</td>
    </tr>
  @endif
          </tbody>
          </table>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal para Nueva Visita -->
  <div class="modal fade" id="nuevaVisitaModal" tabindex="-1" aria-labelledby="nuevaVisitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
      <h5 class="modal-title" id="nuevaVisitaModalLabel">
        <i class="bi bi-calendar-plus text-primary me-2"></i>Programar Visita de Proveedor
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('calendario.store') }}" method="POST">      @csrf
      <div class="modal-body">
        <div class="row">
        <div class="col-md-6 mb-3">
          <label for="proveedor_id" class="form-label fw-semibold">Proveedor <span
            class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-truck"></i></span>
          <select class="form-select" id="proveedor_id" name="proveedor_id" required>
            <option value="">Seleccione un proveedor</option>
            @if(isset($proveedores) && count($proveedores) > 0)
        @foreach($proveedores as $proveedor)
      <option value="{{ isset($proveedor->id) ? $proveedor->id : '' }}">
      {{ isset($proveedor->nombre_empresa) ? $proveedor->nombre_empresa : 'Nombre no disponible' }}
      </option>
    @endforeach
      @endif
          </select>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="sucursal_id" class="form-label fw-semibold">Sucursal <span
            class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-building"></i></span>
          <select class="form-select" id="sucursal_id" name="sucursal_id" required>
            <option value="">Seleccione una sucursal</option>
            @if(isset($sucursales) && count($sucursales) > 0)
        @foreach($sucursales as $sucursal)
      <option value="{{ isset($sucursal->id) ? $sucursal->id : '' }}">
      {{ isset($sucursal->nombre) ? $sucursal->nombre : 'Nombre no disponible' }}
      </option>
    @endforeach
      @endif
          </select>
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-4 mb-3">
          <label for="fecha_visita" class="form-label fw-semibold">Fecha de Visita <span
            class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-date"></i></span>
          <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" required>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="hora_inicio" class="form-label fw-semibold">Hora de Inicio</label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-clock"></i></span>
          <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="hora_fin" class="form-label fw-semibold">Hora de Fin</label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-clock-history"></i></span>
          <input type="time" class="form-control" id="hora_fin" name="hora_fin">
          </div>
        </div>
        </div>

        <div class="mb-3">
        <label for="motivo" class="form-label fw-semibold">Motivo</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-chat-square-text"></i></span>
          <input type="text" class="form-control" id="motivo" name="motivo" placeholder="Propósito de la visita">
        </div>
        </div>

        <div class="row">
        <div class="col-md-6 mb-3">
          <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-tag"></i></span>
          <select class="form-select" id="estado" name="estado" required>
            <option value="programada">Programada</option>
            <option value="completada">Completada</option>
            <option value="cancelada">Cancelada</option>
          </select>
          </div>
        </div>
        </div>

        <div class="mb-3">
        <label for="notas" class="form-label fw-semibold">Notas</label>
        <textarea class="form-control" id="notas" name="notas" rows="3"
          placeholder="Información adicional sobre la visita"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save me-1"></i>Guardar Visita
        </button>
      </div>
      </form>
    </div>
    </div>
  </div>

  <!-- Modal para Editar Visita -->
  <div class="modal fade" id="editarVisitaModal" tabindex="-1" aria-labelledby="editarVisitaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
      <h5 class="modal-title" id="editarVisitaModalLabel">
        <i class="bi bi-calendar-check text-primary me-2"></i>Editar Visita de Proveedor
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editarVisitaForm" method="POST" action="#">
      @csrf
      @method('PUT')
      <div class="modal-body">
        <div class="row">
        <div class="col-md-6 mb-3">
          <label for="edit_proveedor_id" class="form-label fw-semibold">Proveedor <span
            class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-truck"></i></span>
          <select class="form-select" id="edit_proveedor_id" name="proveedor_id" required>
            <option value="">Seleccione un proveedor</option>
            @if(isset($proveedores) && count($proveedores) > 0)
        @foreach($proveedores as $proveedor)
      <option value="{{ isset($proveedor->id) ? $proveedor->id : '' }}">
      {{ isset($proveedor->nombre_empresa) ? $proveedor->nombre_empresa : 'Nombre no disponible' }}
      </option>
    @endforeach
      @endif
          </select>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="edit_sucursal_id" class="form-label fw-semibold">Sucursal <span
            class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-building"></i></span>
          <select class="form-select" id="edit_sucursal_id" name="sucursal_id" required>
            <option value="">Seleccione una sucursal</option>
            @if(isset($sucursales) && count($sucursales) > 0)
        @foreach($sucursales as $sucursal)
      <option value="{{ isset($sucursal->id) ? $sucursal->id : '' }}">
      {{ isset($sucursal->nombre) ? $sucursal->nombre : 'Nombre no disponible' }}
      </option>
    @endforeach
      @endif
          </select>
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-4 mb-3">
          <label for="edit_fecha_visita" class="form-label fw-semibold">Fecha de Visita <span
            class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-date"></i></span>
          <input type="date" class="form-control" id="edit_fecha_visita" name="fecha_visita" required>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="edit_hora_inicio" class="form-label fw-semibold">Hora de Inicio</label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-clock"></i></span>
          <input type="time" class="form-control" id="edit_hora_inicio" name="hora_inicio">
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="edit_hora_fin" class="form-label fw-semibold">Hora de Fin</label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-clock-history"></i></span>
          <input type="time" class="form-control" id="edit_hora_fin" name="hora_fin">
          </div>
        </div>
        </div>

        <div class="mb-3">
        <label for="edit_motivo" class="form-label fw-semibold">Motivo</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-chat-square-text"></i></span>
          <input type="text" class="form-control" id="edit_motivo" name="motivo">
        </div>
        </div>

        <div class="row">
        <div class="col-md-6 mb-3">
          <label for="edit_estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-text bg-light border-0"><i class="bi bi-tag"></i></span>
          <select class="form-select" id="edit_estado" name="estado" required>
            <option value="programada">Programada</option>
            <option value="completada">Completada</option>
            <option value="cancelada">Cancelada</option>
          </select>
          </div>
        </div>
        </div>

        <div class="mb-3">
        <label for="edit_notas" class="form-label fw-semibold">Notas</label>
        <textarea class="form-control" id="edit_notas" name="notas" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-danger me-auto" id="btnEliminarVisita">Eliminar</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary px-4">Actualizar</button>
      </div>
      </form>
      <form id="eliminarVisitaForm" method="POST" style="display: none;" action="#">
      @csrf
      @method('DELETE')
      </form>
    </div>
    </div>
  </div>
@endsection

@section('head')
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
  <style>
    .fc-daygrid-day {
    height: 120px !important;
    }

    .fc-daygrid-day-number {
    font-size: 1.1rem;
    font-weight: 500;
    color: #333;
    }

    .fc-daygrid-day.fc-day-today {
    background-color: rgba(255, 220, 40, 0.15) !important;
    }

    .fc-event {
    cursor: pointer;
    border-radius: 4px;
    padding: 2px 4px;
    font-size: 0.8rem;
    }

    .fc-h-event {
    border: none !important;
    }

    .calendar-toolbar h4 {
    font-size: 1.4rem;
    }

    .list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
    }

    .badge {
    font-weight: 500;
    padding: 0.4em 0.8em;
    }
  </style>
@endsection

@section('scripts')
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/es.js'></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendario');

    // Convertir los eventos PHP en formato JavaScript (con verificación)
    let eventos = [];
    try {
      eventos = @json($eventos ?? []);
    } catch (e) {
      console.error('Error al cargar eventos:', e);
      eventos = [];
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
      height: 800,
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: false, // Usamos nuestra propia barra de herramientas personalizada
      events: eventos,
      editable: true,
      selectable: true,
      dayMaxEvents: true,
      eventDisplay: 'block',

      // Al hacer clic en una fecha vacía
      dateClick: function (info) {
      const fechaVisitaInput = document.getElementById('fecha_visita');
      if (fechaVisitaInput) {
        fechaVisitaInput.value = info.dateStr;
      }
      const nuevaVisitaModal = new bootstrap.Modal(document.getElementById('nuevaVisitaModal'));
      nuevaVisitaModal.show();
      },

      // Al hacer clic en un evento existente
      eventClick: function (info) {
      const evento = info.event;

      if (evento && evento.id) {
        const id = evento.id;

        // Configurar el formulario para editar
        const editarForm = document.getElementById('editarVisitaForm');
        if (editarForm) {
        editarForm.action = `/calendario/${id}`;
        }

        // Intentar obtener propiedades extendidas de manera segura
        const props = evento.extendedProps || {};

        // Llenar los campos del formulario con datos del evento de manera segura
        const proveedorSelect = document.getElementById('edit_proveedor_id');
        if (proveedorSelect && props.proveedor_id) {
        proveedorSelect.value = props.proveedor_id;
        }

        const sucursalSelect = document.getElementById('edit_sucursal_id');
        if (sucursalSelect && props.sucursal_id) {
        sucursalSelect.value = props.sucursal_id;
        }

        // Fecha
        const fechaInput = document.getElementById('edit_fecha_visita');
        if (fechaInput && evento.start) {
        fechaInput.value = evento.start.toISOString().split('T')[0];
        }

        // Horas
        const horaInicioInput = document.getElementById('edit_hora_inicio');
        if (horaInicioInput && props.hora_inicio) {
        horaInicioInput.value = props.hora_inicio;
        }

        const horaFinInput = document.getElementById('edit_hora_fin');
        if (horaFinInput && props.hora_fin) {
        horaFinInput.value = props.hora_fin;
        }

        // Otros campos
        const motivoInput = document.getElementById('edit_motivo');
        if (motivoInput) {
        motivoInput.value = props.motivo || '';
        }

        const estadoSelect = document.getElementById('edit_estado');
        if (estadoSelect) {
        estadoSelect.value = props.estado || 'programada';
        }

        const notasInput = document.getElementById('edit_notas');
        if (notasInput) {
        notasInput.value = props.notas || '';
        }

        // Configurar el formulario para eliminar
        const eliminarForm = document.getElementById('eliminarVisitaForm');
        if (eliminarForm) {
        eliminarForm.action = `/calendario/${id}`;
        }

        // Mostrar modal
        const editarVisitaModal = new bootstrap.Modal(document.getElementById('editarVisitaModal'));
        editarVisitaModal.show();
      }
      },

      // Al arrastrar y soltar un evento
      eventDrop: function (info) {
      const evento = info.event;

      if (evento && evento.id) {
        const id = evento.id;
        const props = evento.extendedProps || {};

        // Crear un formulario para enviar la actualización
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/calendario/${id}`;
        form.style.display = 'none';

        // Agregar campos necesarios de manera segura
        try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
          const csrfField = document.createElement('input');
          csrfField.type = 'hidden';
          csrfField.name = '_token';
          csrfField.value = csrfToken.content;
          form.appendChild(csrfField);
        }

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);

        // Fecha
        if (evento.start) {
          const fechaField = document.createElement('input');
          fechaField.type = 'hidden';
          fechaField.name = 'fecha_visita';
          fechaField.value = evento.start.toISOString().split('T')[0];
          form.appendChild(fechaField);
        }

        // Otros campos
        if (props.proveedor_id) {
          const proveedorField = document.createElement('input');
          proveedorField.type = 'hidden';
          proveedorField.name = 'proveedor_id';
          proveedorField.value = props.proveedor_id;
          form.appendChild(proveedorField);
        }

        if (props.sucursal_id) {
          const sucursalField = document.createElement('input');
          sucursalField.type = 'hidden';
          sucursalField.name = 'sucursal_id';
          sucursalField.value = props.sucursal_id;
          form.appendChild(sucursalField);
        }

        if (props.estado) {
          const estadoField = document.createElement('input');
          estadoField.type = 'hidden';
          estadoField.name = 'estado';
          estadoField.value = props.estado;
          form.appendChild(estadoField);
        } else {
          const estadoField = document.createElement('input');
          estadoField.type = 'hidden';
          estadoField.name = 'estado';
          estadoField.value = 'programada'; // Valor por defecto
          form.appendChild(estadoField);
        }

        // Enviar formulario
        document.body.appendChild(form);
        form.submit();
        } catch (e) {
        console.error('Error al actualizar el evento:', e);
        alert('Error al actualizar la visita. Por favor, inténtelo de nuevo.');
        }
      }
      }
    });

    // Intentar renderizar el calendario dentro de un bloque try-catch
    try {
      calendar.render();
    } catch (e) {
      console.error('Error al renderizar el calendario:', e);
      document.getElementById('calendario').innerHTML = '<div class="alert alert-danger m-3">Error al cargar el calendario. Por favor, recargue la página.</div>';
    }

    // Conectar los botones de la barra de herramientas personalizada de manera segura
    try {
      const btnPrev = document.getElementById('btn-prev');
      if (btnPrev) {
      btnPrev.addEventListener('click', function () {
        calendar.prev();
        const titleEl = document.getElementById('calendar-title');
        if (titleEl) {
        titleEl.innerText = calendar.view.title;
        }
      });
      }

      const btnNext = document.getElementById('btn-next');
      if (btnNext) {
      btnNext.addEventListener('click', function () {
        calendar.next();
        const titleEl = document.getElementById('calendar-title');
        if (titleEl) {
        titleEl.innerText = calendar.view.title;
        }
      });
      }

      const btnToday = document.getElementById('btn-today');
      if (btnToday) {
      btnToday.addEventListener('click', function () {
        calendar.today();
        const titleEl = document.getElementById('calendar-title');
        if (titleEl) {
        titleEl.innerText = calendar.view.title;
        }
      });
      }

      const btnMonth = document.getElementById('btn-month');
      if (btnMonth) {
      btnMonth.addEventListener('click', function () {
        calendar.changeView('dayGridMonth');
        updateViewButtons('btn-month');
      });
      }

      const btnWeek = document.getElementById('btn-week');
      if (btnWeek) {
      btnWeek.addEventListener('click', function () {
        calendar.changeView('timeGridWeek');
        updateViewButtons('btn-week');
      });
      }

      const btnDay = document.getElementById('btn-day');
      if (btnDay) {
      btnDay.addEventListener('click', function () {
        calendar.changeView('timeGridDay');
        updateViewButtons('btn-day');
      });
      }

      const btnAgenda = document.getElementById('btn-agenda');
      if (btnAgenda) {
      btnAgenda.addEventListener('click', function () {
        calendar.changeView('listMonth');
        updateViewButtons('btn-agenda');
      });
      }

      function updateViewButtons(activeBtn) {
      const buttons = ['btn-month', 'btn-week', 'btn-day', 'btn-agenda'];
      buttons.forEach(btn => {
        const btnEl = document.getElementById(btn);
        if (btnEl) {
        if (btn === activeBtn) {
          btnEl.classList.remove('btn-outline-secondary');
          btnEl.classList.add('btn-secondary');
        } else {
          btnEl.classList.remove('btn-secondary');
          btnEl.classList.add('btn-outline-secondary');
        }
        }
      });
      }

      // Manejar el botón de eliminar
      const btnEliminar = document.getElementById('btnEliminarVisita');
      if (btnEliminar) {
      btnEliminar.addEventListener('click', function () {
        if (confirm('¿Está seguro que desea eliminar esta visita?')) {
        const formEliminar = document.getElementById('eliminarVisitaForm');
        if (formEliminar) {
          formEliminar.submit();
        }
        }
      });
      }
    } catch (e) {
      console.error('Error al configurar los botones del calendario:', e);
    }
    });
  </script>
@endsection