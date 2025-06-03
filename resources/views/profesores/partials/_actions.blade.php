<a href="{{ route('profesores.edit', $profesor) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

<button class="btn btn-sm @if($profesor->estado == 'activo') btn-danger @else btn-success @endif btn-delete" data-id="{{ $profesor->id }}" data-estado="{{ $profesor->estado }}">
    <i class="fas @if($profesor->estado == 'activo') fa-ban @else fa-eye @endif"></i>
</button>