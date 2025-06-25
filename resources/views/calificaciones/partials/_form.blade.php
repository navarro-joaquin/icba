@csrf
@if(isset($calificacion))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="tipo">Tipo de Calificación:</label>
    <select name="tipo" class="form-control" id="tipo">
        <option value="examen_1" {{ old('tipo', $calificacion->tipo ?? '') == 'examen_1' ? 'selected' : '' }}>Examen 1</option>
        <option value="examen_2" {{ old('tipo', $user->tipo ?? '') == 'examen_2' ? 'selected' : '' }}>Examen 2</option>
        <option value="nota_final" {{ old('tipo', $user->tipo ?? '') == 'nota_final' ? 'selected' : '' }}>Nota Final</option>
    </select>
</div>

<div class="mb-3">
    <label for="nota">Nota:</label>
    <input type="number" name="nota" id="nota" class="form-control" value="{{ old('nota', $calificacion->nota ?? '') }}">
</div>

<div class="mb-3">
    <label for="inscripcion_id">Inscripción:</label>
    <select name="inscripcion_id" id="inscripcion_id" class="form-control">
        @forelse ($inscripciones as $inscripcion)
            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id', $asistencia->inscripcion_id ?? '') == $inscripcion->id ? 'selected' : '' }}>
                {{ $inscripcion->alumno->nombre }} - ({{ $inscripcion->cursoGestion->nombre }})
            </option>
        @empty
            <option value="">No hay inscripciones disponibles</option>
        @endforelse
    </select>
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($calificacion) ? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('calificaciones.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>
