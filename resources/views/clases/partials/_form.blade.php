@csrf
@if (isset($clase))
    @method ('PUT')
@endif

<div class="mb-3">
    <label for="curso_gestion_id">Curso y Gestión:</label>
    <select name="curso_gestion_id" id="curso_gestion_id" class="form-control">
        @forelse ($cursosGestiones as $cursoGestion)
            <option value="{{ $cursoGestion->id }}" {{ old('curso_gestion_id', $clase->curso_gestion_id ?? '') == $cursoGestion->id ? 'selected' : '' }}>
                {{ $cursoGestion->nombre }}
            </option>
        @empty
            <option value="">-- No hay cursos disponibles --</option>
        @endforelse
    </select>
    @error('curso_gestion_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="numero_clase">N° de Clase</label>
    <input type="number" name="numero_clase" id="numero_clase" class="form-control" value="{{ old('numero_clase', $clase->numero_clase ?? '') }}">
    @error('numero_clase')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_clase">Fecha de Clase</label>
    <input type="date" name="fecha_clase" id="fecha_clase" class="form-control" value="{{ old('fecha_clase', $clase->fecha_clase ?? '') }}">
    @error('fecha_clase')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="tema">Tema</label>
    <input type="text" name="tema" id="tema" class="form-control" value="{{ old('tema', $clase->tema ?? '') }}">
    @error('tema')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($clase) ? 'Actualizar' : 'Registrar' }}
</button>
