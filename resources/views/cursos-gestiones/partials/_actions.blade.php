@can('editar cursos-gestiones')
    <a href="{{ route('cursos-gestiones.edit', $curso_gestion) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar cursos-gestiones')
    <button class="btn btn-sm @if($curso_gestion->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $curso_gestion->id }}" data-estado="{{ $curso_gestion->estado }}">
        <i class="fas @if($curso_gestion->estado == 'activo') fa-ban @else fa-check @endif"></i>
    </button>
@endcan
