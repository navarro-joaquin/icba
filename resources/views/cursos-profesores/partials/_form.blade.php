@csrf
@if (isset($curso_profesor))
    @method ('PUT')
@endif

<div class="mb-3">
    <label for="curso_ciclo_id">Curso y Ciclo <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="curso_ciclo_id" id="curso_ciclo_id" class="form-control">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($cursosCiclos as $cursoCiclo)
            <option value="{{ $cursoCiclo->id }}" {{ old('curso_ciclo_id', $curso_profesor->curso_ciclo_id ?? '') == $cursoCiclo->id ? 'selected' : '' }}>
                {{ $cursoCiclo->nombre }}
            </option>
        @empty
            <option value="">-- No hay cursos disponibles --</option>
        @endforelse
    </select>
    @error('curso_ciclo_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="profesor_id">Profesor <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="profesor_id" id="profesor_id" class="form-control">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($profesores as $profesor)
            <option value="{{ $profesor->id }}" {{ old('profesor_id', $curso_profesor->profesor_id ?? '') == $profesor->id ? 'selected' : '' }}>
                {{ $profesor->nombre }}
            </option>
        @empty
            <option value="">-- No hay profesores disponibles --</option>
        @endforelse
    </select>
    @error('profesor_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($curso_profesor) ? 'Actualizar' : 'Registrar' }}
</button>
