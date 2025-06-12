@can('editar alumnos')
    <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar alumnos')
    <button class="btn btn-sm @if($alumno->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $alumno->id }}" data-estado="{{ $alumno->estado }}">
        <i class="fas @if($alumno->estado == 'activo') fa-ban @else fa-check @endif"></i>
    </button>
@endcan
