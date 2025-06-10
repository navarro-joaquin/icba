@csrf
@if(isset($pago))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="alumno_id">Alumno</label>
    <select name="alumno_id" class="form-control" id="alumno_id">
        @forelse ($alumnos as $alumno)
            <option value="{{ $alumno->id }}" {{ old('alumno_id', $pago->alumno_id ?? '') == $alumno->id ? 'selected' : '' }}>
                {{ $alumno->nombre }}
            </option>
        @empty
            <option value="">No hay alumnos registrados</option>
        @endforelse
    </select>
</div>

<div class="mb-3">
    <label for="inscripcion_id">Inscripción</label>
    <select name="inscripcion_id" class="form-control" id="inscripcion_id">
        @forelse ($inscripciones as $inscripcion)
            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id', $pago->inscripcion_id ?? '') == $inscripcion->id ? 'selected' : '' }}>
                {{ $inscripcion->curso_gestion->nombre }}
            </option>
        @empty
            <option value="">No hay inscripiciones registradas</option>
        @endforelse
    </select>
</div>

<div class="mb-3">
    <label for="fecha_pago">Fecha de Pago</label>
    <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" value="{{ old('fecha_pago', $pago->fecha_pago ?? '') }}">
</div>

<div class="mb-3">
    <label for="monto">Monto (Bs.)</label>
    <input type="number" name="monto" id="monto" class="form-control" value="{{ old('monto', $pago->monto ?? '') }}">
</div>

<div class="mb-3">
    <label for="forma_pago">Forma de Pago</label>
    <select name="forma_pago" class="form-control" id="forma_pago">
        <option value="efectivo" {{ old('forma_pago', $user->forma_pago?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
        <option value="transferencia" {{ old('forma_pago', $user->forma_pago?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
    </select>
</div>

<div class="mb-3">
    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $pago->descripcion ?? '') }}">
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($pago) ? 'Actualizar' : 'Registrar' }}
</button>
<a href="{{ route('pagos.index') }}" class="btn btn-info">
    <i class="fas fa-arrow-left"></i> Volver
</a>
