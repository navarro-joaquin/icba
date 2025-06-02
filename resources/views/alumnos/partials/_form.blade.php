@csrf
@if(isset($alumno))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Alumno</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $alumno->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento ?? '') }}">
</div>

<div class="mb-3">
    <label for="user_id">Usuario</label>
    <select name="user_id" class="form-control">
        @if($usuarios->count() == 0)
            <option value="">No hay usuarios registrados</option>
        @else
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id }}" {{ old('user_id', $alumno->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->username }}
                </option>
            @endforeach
        @endif
    </select>
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($user)? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('alumnos.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>