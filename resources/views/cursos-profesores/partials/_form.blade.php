@csrf
@if (isset($curso_profesor))
    @method ('PUT')
@endif

<div class="mb-3">
    <label for="curso_profesor_id">Curso y Gestión:</label>
    <select name="curso_profesor_id" id="curso_profesor_id" class="form-control">
        @forelse ($cursosGestiones as $cursoGestion)
            <option value="{{ $cursoGestion->id }}" {{ old('curso_profesor_id', $curso_profesor->curso_gestion_id ?? '') == $cursoGestion->id ? 'selected' : '' }}>
                {{ $cursoGestion->nombre }}
            </option>
        @empty
            <option value="">No hay cursos disponibles</option>
        @endforelse
    </select>
</div>

<div class="mb-3">
    <label for="profesor_id">Profesor:</label>
    <select name="profesor_id" id="profesor_id" class="form-control">
        @forelse ($profesores as $profesor)
            <option value="{{ $profesor->id }}" {{ old('profesor_id', $curso_profesor->profesor_id ?? '') == $profesor->id ? 'selected' : '' }}>
                {{ $profesor->nombre }}
            </option>
        @empty
            <option value="">No hay profesores disponibles</option>
        @endforelse
    </select>
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($alumno)? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('alumnos.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>