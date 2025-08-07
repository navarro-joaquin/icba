@csrf
@if(isset($profesor))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Profesor <span class="text-danger" title="El campo es requerido">*</span></label>
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
    <label for="user_id">Usuario (Email) <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="user_id" class="form-control" id="user_id">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($usuarios as $usuario)
            <option value="{{ $usuario->id }}" {{ old('user_id', $profesor->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
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
    <i class="fas fa-save"></i> {{ isset($profesor) ? 'Actualizar' : 'Registrar' }}
</button>
