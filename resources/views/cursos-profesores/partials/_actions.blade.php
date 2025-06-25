@can('editar cursos-profesores')
    <a href="{{ route('cursos-profesores.edit', $curso_profesor) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar cursos-profesores')
    <button class="btn btn-sm @if($curso_profesor->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $curso_profesor->id }}" data-estado="{{ $curso_profesor->estado }}">
        <i class="fas @if($curso_profesor->estado == 'activo') fa-ban @else fa-check @endif"></i>
    </button>
@endcan
