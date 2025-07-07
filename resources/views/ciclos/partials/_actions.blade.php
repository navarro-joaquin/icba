@can('editar ciclos')
    <a href="{{ route('ciclos.edit', $ciclo) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar ciclos')
    <button class="btn btn-sm @if($ciclo->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $ciclo->id }}" data-estado="{{ $ciclo->estado }}">
        <i class="fas @if($ciclo->estado == 'activo') fa-ban @else fa-eye @endif"></i>
    </button>
@endcan
