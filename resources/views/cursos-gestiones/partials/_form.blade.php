@csrf
@if (isset($curso_gestion))
    @method ('PUT')
@endif

<div class="mb-3">
    <label for="curso_id">Curso:</label>
    <select name="curso_id" id="curso_id" class="form-control">
        @forelse ($cursos as $curso)
            <option value="{{ $curso->id }}" {{ old('curso_id', $curso_gestion->curso_id ?? '') == $curso->id ? 'selected' : '' }}>
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
    <label for="gestion_id">Gestiones:</label>
    <select name="gestion_id" id="gestion_id" class="form-control">
        @forelse ($gestiones as $gestion)
            <option value="{{ $gestion->id }}" {{ old('gestion_id', $curso_gestion->gestion_id ?? '') == $gestion->id ? 'selected' : '' }}>
                {{ $gestion->nombre }}
            </option>
        @empty
            <option value="">-- No hay gestiones disponibles --</option>
        @endforelse
    </select>
    @error('gestion_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($alumno) ? 'Actualizar' : 'Registrar' }}
</button>
