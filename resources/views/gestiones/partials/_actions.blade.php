@can('editar gestiones')
    <a href="{{ route('gestiones.edit', $gestion) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar gestiones')
    <button class="btn btn-sm @if($gestion->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $gestion->id }}" data-estado="{{ $gestion->estado }}">
        <i class="fas @if($gestion->estado == 'activo') fa-ban @else fa-eye @endif"></i>
    </button>
@endcan
