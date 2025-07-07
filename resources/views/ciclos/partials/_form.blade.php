@csrf
@if(isset($ciclo))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Ciclo</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $ciclo->nombre ?? '') }}">
    @error('nombre')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $ciclo->fecha_inicio ?? '') }}">
    @error('fecha_inicio')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_fin">Fecha de finalización</label>
    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $ciclo->fecha_fin ?? '') }}">
    @error('fecha_fin')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($ciclo) ? 'Actualizar' : 'Registrar' }}
</button>
