@csrf
@if (isset($curso_ciclo))
    @method ('PUT')
@endif

<div class="mb-3">
    <label for="curso_id">Curso <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="curso_id" id="curso_id" class="form-control">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($cursos as $curso)
            <option value="{{ $curso->id }}" {{ old('curso_id', $curso_ciclo->curso_id ?? '') == $curso->id ? 'selected' : '' }}>
                {{ $curso->nombre }}
            </option>
        @empty
            <option value="">-- No hay cursos disponibles --</option>
        @endforelse
    </select>
    @error('curso_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="ciclo_id">Ciclos <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="ciclo_id" id="ciclo_id" class="form-control">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($ciclos as $ciclo)
            <option value="{{ $ciclo->id }}" {{ old('ciclo_id', $curso_ciclo->ciclo_id ?? '') == $ciclo->id ? 'selected' : '' }}>
                {{ $ciclo->nombre }}
            </option>
        @empty
            <option value="">-- No hay ciclos disponibles --</option>
        @endforelse
    </select>
    @error('ciclo_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_inicio">Fecha de inicio <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $curso_ciclo->fecha_inicio ?? '') }}">
    @error('fecha_inicio')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_fin">Fecha de finalización <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $curso_ciclo->fecha_fin ?? '') }}">
    @error('fecha_fin')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($curso_ciclo) ? 'Actualizar' : 'Registrar' }}
</button>
