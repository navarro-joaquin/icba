@csrf

@if(isset($user))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="username">Nombre de Usuario</label>
    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username ?? '') }}">
    @error('username')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email?? '') }}">
    @error('email')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>


<div class="mb-3">
    <label for="role">Rol</label>
    <select name="role" class="form-control" id="role">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($roles as $role)
            @if (auth()->user()->hasRole('gestor') && ($role->name == 'admin' || $role->name == 'gestor'))
                <!-- Skip admin and gestor roles for users with gestor role -->
            @else
                <option value="{{ $role->name }}" {{ old('role', $user->role?? '') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
            @endif
        @empty
            <option value="">-- No hay roles disponibles --</option>
        @endforelse
    </select>
    @error('role')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3" id="alumno" style="display: none">
    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento ?? '') }}">
    @error('fecha_nacimiento')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3 hidden" id="profesor" style="display: none">
    <label for="especialidad">Especialidad</label>
    <input type="text" name="especialidad" id="especialidad" class="form-control" value="{{ old('especialidad', $profesor->especialidad ?? '') }}">
    @error('especialidad')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>


<div class="mb-3">
    <label for="password">Contraseña</label>
    <div class="input-group mb-3">
        <input type="password" name="password" id="password" class="form-control">
        <button type="button" class="btn btn-secondary" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
        </button>
    </div>
    @error('password')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($user) ? 'Actualizar' : 'Registrar' }}
</button>
