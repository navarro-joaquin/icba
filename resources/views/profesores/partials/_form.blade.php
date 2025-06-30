@csrf
@if(isset($profesor))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Profesor</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $profesor->nombre ?? '') }}">
    @error('nombre')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="especialidad">Especialidad</label>
    <input type="text" name="especialidad" id="especialidad" class="form-control" value="{{ old('especialidad', $profesor->especialidad ?? '') }}">
    @error('especialidad')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="user_id">Usuario</label>
    <select name="user_id" class="form-control" id="user_id">
        @forelse ($usuarios as $usuario)
            <option value="{{ $usuario->id }}" {{ old('user_id', $alumno->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
                {{ $usuario->username }}
            </option>
        @empty
            <option value="">-- No hay usuarios disponibles --</option>
        @endforelse
    </select>
    @error('user_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($profesor) ? 'Actualizar' : 'Registrar' }}
</button>
