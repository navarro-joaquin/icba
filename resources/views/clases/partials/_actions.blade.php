@can('editar clases')
<a href="{{ route('clases.edit', $clase) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar clases')
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $clase->id }}">
        <i class="fas fa-trash"></i>
    </button>
@endcan
