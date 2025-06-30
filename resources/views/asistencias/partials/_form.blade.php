@csrf
@if (isset($asistencia))
    @method ('PUT')
@endif

<div class="mb-3">
    <label for="inscripcion_id">Inscripción:</label>
    <select name="inscripcion_id" id="inscripcion_id" class="form-control">
        @forelse ($inscripciones as $inscripcion)
            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id', $asistencia->inscripcion_id ?? '') == $inscripcion->id ? 'selected' : '' }}>
                {{ $inscripcion->alumno->nombre }} - ({{ $inscripcion->cursoGestion->nombre }})
            </option>
        @empty
            <option value="">-- No hay inscripciones disponibles --</option>
        @endforelse
    </select>
    @error('inscripcion_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="clase_id">Clase:</label>
    <select name="clase_id" id="clase_id" class="form-control">
        @forelse ($clases as $clase)
            <option value="{{ $clase->id }}" {{ old('clase_id', $asistencia->clase_id ?? '') == $clase->id ? 'selected' : '' }}>
                N° {{ $clase->numero_clase }} - ({{ $clase->fecha_clase }})
            </option>
        @empty
            <option value="">-- No hay clases disponibles --</option>
        @endforelse
    </select>
    @error('clase_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="presente">Presente:</label>
    <input
        type="checkbox"
        name="presente"
        id="presente"
        class="form-control"
        value="1"
        @checked(old('presente', $asistencia->presente ?? 0))
    >
    @error('presente')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($asistencia) ? 'Actualizar' : 'Registrar' }}
</button>
