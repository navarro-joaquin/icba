@csrf
@if(isset($matricula))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="alumno_id">Alumno</label>
    <select name="alumno_id" class="form-control" id="alumno_id">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($alumnos as $alumno)
            <option value="{{ $alumno->id }}" {{ old('alumno_id', $matricula->alumno_id ?? '') == $alumno->id ? 'selected' : '' }}>
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
    <label for="anio">Año</label>
    <input type="number" name="anio" id="anio" min="1900" max="2100" step="1" class="form-control" value="{{ old('anio', $matricula->anio ?? date('Y')) }}">
    @error('anio')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="monto_total">Monto Total (Bs.)</label>
    <input type="number" name="monto_total" id="monto_total" class="form-control" value="{{ old('monto_total', $matricula->monto_total ?? '') }}">
    @error('monto_total')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($matricula) ? 'Actualizar' : 'Registrar' }}
</button>
