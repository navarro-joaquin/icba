@csrf
@if(isset($calificacion))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="tipo">Tipo de Calificación:</label>
    <select name="tipo" class="form-control" id="tipo">
        <option value="examen_1" {{ old('tipo', $calificacion->tipo ?? '') == 'examen_1' ? 'selected' : '' }}>Examen 1</option>
        <option value="examen_2" {{ old('tipo', $calificacion->tipo ?? '') == 'examen_2' ? 'selected' : '' }}>Examen 2</option>
        <option value="nota_final" {{ old('tipo', $calificacion->tipo ?? '') == 'nota_final' ? 'selected' : '' }}>Nota Final</option>
    </select>
    @error('tipo')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="nota">Nota:</label>
    <input type="number" name="nota" id="nota" class="form-control" value="{{ old('nota', $calificacion->nota ?? '') }}">
    @error('nota')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="inscripcion_id">Inscripción:</label>
    <select name="inscripcion_id" id="inscripcion_id" class="form-control">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($inscripciones as $inscripcion)
            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id', $asistencia->inscripcion_id ?? '') == $inscripcion->id ? 'selected' : '' }}>
                {{ $inscripcion->alumno->nombre }} - ({{ $inscripcion->cursoCiclo->nombre }})
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

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($calificacion) ? 'Actualizar' : 'Registrar' }}
</button>
