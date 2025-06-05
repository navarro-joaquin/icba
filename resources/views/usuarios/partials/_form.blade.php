@csrf

@if(isset($user))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="username">Nombre de Usuario</label>
    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username ?? '') }}">
</div>

<div class="mb-3">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email?? '') }}">
</div>

<div class="mb-3">
    <label for="role">Rol</label>
    <select name="role" class="form-control" id="role">
        <option value="admin" {{ old('role', $user->role?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
        <option value="alumno" {{ old('role', $user->role?? '') == 'alumno' ? 'selected' : '' }}>Alumno</option>
        <option value="profesor" {{ old('role', $user->role?? '') == 'profesor' ? 'selected' : '' }}>Profesor</option>
        <option value="gestor" {{ old('role', $user->role?? '') == 'gestor' ? 'selected' : '' }}>Gestor</option>
    </select>
</div>

<div class="mb-3">
    <label for="password">Contraseña</label>
    <input type="password" name="password" id="password" class="form-control">
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($user) ? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('usuarios.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>
