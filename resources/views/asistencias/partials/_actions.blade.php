@can('editar asistencias')
    <a href="{{ route('asistencias.edit', $asistencia) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar asistencias')
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $asistencia->id }}">
        <i class="fas fa-trash"></i>
    </button>
@endcan
