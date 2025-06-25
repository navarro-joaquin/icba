@can('editar inscripciones')
    <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar inscripciones')
    <button class="btn btn-sm @if($inscripcion->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $inscripcion->id }}" data-estado="{{ $inscripcion->estado }}">
        <i class="fas @if($inscripcion->estado == 'activo') fa-ban @else fa-check @endif"></i>
    </button>
@endcan
