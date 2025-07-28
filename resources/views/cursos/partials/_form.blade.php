@csrf
@if(isset($curso))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre">Nombre del Curso  <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $curso->nombre ?? '') }}">
    @error('nombre')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion">Descripción del Curso  <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $curso->descripcion ?? '') }}">
    @error('descripcion')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($curso) ? 'Actualizar' : 'Registrar' }}
</button>
