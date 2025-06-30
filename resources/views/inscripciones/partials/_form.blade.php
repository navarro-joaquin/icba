@csrf
@if(isset($inscripcion))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="alumno_id">Alumno</label>
    <select name="alumno_id" class="form-control" id="alumno_id">
        @forelse ($alumnos as $alumno)
            <option value="{{ $alumno->id }}" {{ old('alumno_id', $inscripcion->alumno_id ?? '') == $alumno->id ? 'selected' : '' }}>
                {{ $alumno->nombre }}
            </option>
        @empty
            <option value="">-- No hay alumnos disponibles --</option>
        @endforelse
    </select>
    @error('alumno_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="curso_gestion_id">Curso y Gestión</label>
    <select name="curso_gestion_id" class="form-control" id="curso_gestion_id">
        @forelse ($cursosGestiones as $cursoGestion)
            <option value="{{ $cursoGestion->id }}" {{ old('curso_gestion_id', $inscripcion->curso_gestion_id ?? '') == $cursoGestion->id ? 'selected' : '' }}>
                {{ $cursoGestion->nombre }}
            </option>
        @empty
            <option value="">-- No hay Cursos y Gestiones disponibles --</option>
        @endforelse
    </select>
    @error('curso_gestion_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_inscripcion">Fecha de Inscripción</label>
    <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control" value="{{ old('fecha_inscripcion', $inscripcion->fecha_inscripcion ?? '') }}">
    @error('fecha_inscripcion')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="monto_total">Monto Total (Bs.)</label>
    <input type="number" name="monto_total" id="monto_total" class="form-control" value="{{ old('monto_total', $inscripcion->monto_total ?? '') }}">
    @error('monto_total')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($inscripcion) ? 'Actualizar' : 'Registrar' }}
</button>
