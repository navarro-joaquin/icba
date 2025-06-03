<a href="{{ route('cursos.edit', $curso) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

<button class="btn btn-sm @if($curso->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $curso->id }}" data-estado="{{ $curso->estado }}">
    <i class="fas @if($curso->estado == 'activo') fa-ban @else fa-eye @endif"></i>
</button>