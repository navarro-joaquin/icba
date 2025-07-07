@csrf
@if(isset($alumno))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Alumno</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $alumno->nombre ?? '') }}">
    @error('nombre')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento ?? '') }}">
    @error('fecha_nacimiento')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="user_id">Usuario (Email)</label>
    <select name="user_id" class="form-control" id="user_id">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($usuarios as $usuario)
            <option value="{{ $usuario->id }}" {{ old('user_id', $alumno->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
                {{ $usuario->email }}
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
    <i class="fas fa-save"></i> {{ isset($alumno) ? 'Actualizar' : 'Registrar' }}
</button>
