@csrf
@if(isset($alumno))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Alumno</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $alumno->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento ?? '') }}">
</div>

<div class="mb-3">
    <label for="user_id">Usuario</label>
    <select name="user_id" class="form-control" id="user_id">
        @forelse ($usuarios as $usuario)
            <option value="{{ $usuario->id }}" {{ old('user_id', $alumno->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
                {{ $usuario->username }}
            </option>
        @empty
            <option value="">No hay usuarios registrados</option>
        @endforelse
    </select>
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($alumno)? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('alumnos.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>