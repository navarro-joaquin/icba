@csrf
@if(isset($calificacion))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="inscripcion_id">Inscripción (Curso) <span class="text-danger" title="El campo es requerido">*</span></label>
    <select name="inscripcion_id" id="inscripcion_id" class="form-control">
        <option value="">-- Seleccione una opción --</option>
        @forelse ($inscripciones as $inscripcion)
            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id', $calificacion->inscripcion_id ?? '') == $inscripcion->id ? 'selected' : '' }}>
                {{ $inscripcion->alumno->nombre }} - ({{ $inscripcion->cursoCiclo->nombre }})
            </option>
        @empty
            <option value="">-- No hay inscripciones disponibles --</option>
        @endforelse
    </select>
    @error('inscripcion_id')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="examen_1">Examen 1</label>
    <input type="number" name="examen_1" id="examen_1" class="form-control" value="{{ old('examen_1', $calificacion->examen_1 ?? '') }}">
    @error('examen_1')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="examen_2">Examen 2</label>
    <input type="number" name="examen_2" id="examen_2" class="form-control" value="{{ old('examen_2', $calificacion->examen_2 ?? '') }}">
    @error('examen_2')
    <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="nota_final">Nota Final</label>
    <input type="number" name="nota_final" id="nota_final" class="form-control" value="{{ old('nota_final', $calificacion->nota_final ?? '') }}">
    @error('nota_final')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ isset($calificacion) ? 'Actualizar' : 'Registrar' }}
</button>
