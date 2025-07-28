@csrf
@if(isset($inscripcion))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="alumno_id">Alumno <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="alumno_id" class="form-control" id="alumno_id">
        <option value="">-- Seleccione una opción --</option>
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
    <label for="curso_ciclo_id">Curso y Ciclo <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="curso_ciclo_id" class="form-control" id="curso_ciclo_id">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($cursosCiclos as $cursoCiclo)
            <option value="{{ $cursoCiclo->id }}" {{ old('curso_ciclo_id', $inscripcion->curso_ciclo_id ?? '') == $cursoCiclo->id ? 'selected' : '' }}>
                {{ $cursoCiclo->nombre }}
            </option>
        @empty
            <option value="">-- No hay Cursos y Ciclos disponibles --</option>
        @endforelse
    </select>
    @error('curso_ciclo_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_inscripcion">Fecha de Inscripción <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control" value="{{ old('fecha_inscripcion', $inscripcion->fecha_inscripcion ?? '') }}">
    @error('fecha_inscripcion')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="monto_total">Monto Total (Bs.) <span class="text-danger" title="El campo es requerido">*</span></label>
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
