@can('editar calificaciones')
    <a href="{{ route('calificaciones.edit', $calificacion) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar calificaciones')
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $calificacion->id }}">
        <i class="fas fa-trash"></i>
    </button>
@endcan
