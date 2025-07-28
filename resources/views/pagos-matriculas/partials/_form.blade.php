@csrf
@if(isset($pago_matricula))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="alumno_id">Alumno <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="alumno_id" class="form-control" id="alumno_id">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($alumnos as $alumno)
            <option value="{{ $alumno->id }}" {{ old('alumno_id', $pago_matricula->alumno_id ?? '') == $alumno->id ? 'selected' : '' }}>
                {{ $alumno->nombre }}
            </option>
        @empty
            <option value="">-- No hay alumnos disponibles --</option>
        @endforelse
    </select>
    @error('alumno_id')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="matricula_id">Matricula <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="matricula_id" class="form-control" id="matricula_id">
        <option value="">-- Seleccione una opción --</option>
    </select>
    @error('matricula_id')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_pago">Fecha de Pago <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" value="{{ old('fecha_pago', $pago_matricula->fecha_pago ?? '') }}">
    @error('fecha_pago')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="monto">Monto (Bs.) <span class="text-danger" title="El campo es requerido">*</span></label>
    <input type="number" name="monto" id="monto" class="form-control" value="{{ old('monto', $pago_matricula->monto ?? '') }}">
    @error('monto')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="forma_pago">Forma de Pago <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="forma_pago" class="form-control" id="forma_pago">
        <option value="efectivo" {{ old('forma_pago', $pago_matricula->forma_pago?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
        <option value="transferencia" {{ old('forma_pago', $pago_matricula->forma_pago?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
    </select>
    @error('forma_pago')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $pago_matricula->descripcion ?? '') }}">
    @error('descripcion')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($pago_matricula) ? 'Actualizar' : 'Registrar' }}
</button>
