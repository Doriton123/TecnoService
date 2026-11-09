<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror"
            required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected(old('cliente_id', $solicitud->cliente_id ?? '') == $cliente->id)>
                    {{ $cliente->nombre_completo }} - {{ $cliente->nit }}
                </option>
            @endforeach
        </select>
        @error('cliente_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Equipo del cliente</label>
        <select name="equipo_id" id="equipo_id" class="form-select @error('equipo_id') is-invalid @enderror" required>
            <option value="">Seleccione un equipo</option>
            @foreach($equipos as $equipo)
                <option value="{{ $equipo->id }}" data-cliente="{{ $equipo->cliente_id }}" @selected(old('equipo_id', $solicitud->equipo_id ?? '') == $equipo->id)>
                    {{ $equipo->tipo_equipo }} -
                    {{ $equipo->marca }} {{ $equipo->modelo }}
                    ({{ $equipo->numero_serie ?? 'Sin serie' }})
                </option>
            @endforeach
        </select>
        @error('equipo_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha de recepción</label>
        <input type="date" name="fecha_recepcion" class="form-control @error('fecha_recepcion') is-invalid @enderror"
            value="{{ old('fecha_recepcion', isset($solicitud) ? $solicitud->fecha_recepcion->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required>
        @error('fecha_recepcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Tipo de servicio</label>
        <select name="tipo_servicio" class="form-select" required>
            <option value="">Seleccione un servicio</option>
            @foreach(['Mantenimiento', 'Reparación'] as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo_servicio', $solicitud->tipo_servicio ?? '') === $tipo)>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Descripción del problema</label>
        <textarea name="descripcion_problema" class="form-control @error('descripcion_problema') is-invalid @enderror"
            rows="4" required>{{ old('descripcion_problema', $solicitud->descripcion_problema ?? '') }}</textarea>
        @error('descripcion_problema')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" class="form-control"
            rows="3">{{ old('observaciones', $solicitud->observaciones ?? '') }}</textarea>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cliente = document.getElementById('cliente_id');
        const equipo = document.getElementById('equipo_id');

        function filtrarEquipos() {
            const clienteId = cliente.value;

            Array.from(equipo.options).forEach(function (opcion) {
                if (!opcion.value) return;

                opcion.hidden = opcion.dataset.cliente !== clienteId;
                opcion.disabled = opcion.dataset.cliente !== clienteId;
            });

            const seleccionado = equipo.options[equipo.selectedIndex];

            if (seleccionado && seleccionado.disabled) {
                equipo.value = '';
            }
        }

        cliente.addEventListener('change', function () {
            equipo.value = '';
            filtrarEquipos();
        });

        filtrarEquipos();
    });
</script>