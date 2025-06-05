@csrf
@if(isset($curso))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Curso</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $curso->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="descripcion">Descripción del Curso</label>
    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $curso->descripcion ?? '') }}">
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($curso) ? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('cursos.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>