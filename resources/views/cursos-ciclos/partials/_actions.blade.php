@can('editar cursos-ciclos')
    <a href="{{ route('cursos-ciclos.edit', $curso_ciclo) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar cursos-ciclos')
    <button class="btn btn-sm @if($curso_ciclo->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $curso_ciclo->id }}" data-estado="{{ $curso_ciclo->estado }}">
        <i class="fas @if($curso_ciclo->estado == 'activo') fa-ban @else fa-check @endif"></i>
    </button>
@endcan
