@csrf
@if(isset($gestion))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre de la Gestión</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $gestion->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $gestion->fecha_inicio ?? '') }}">
</div>

<div class="mb-3">
    <label for="fecha_fin">Fecha de finalización</label>
    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $gestion->fecha_fin ?? '') }}">
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($gestion)? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('gestiones.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>