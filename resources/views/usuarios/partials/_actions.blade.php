<a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

<button class="btn btn-sm @if($user->status == 'active') btn-danger @else btn-success @endif btn-delete" data-id="{{ $user->id }}" data-estado="{{ $user->status }}">
    <i class="fas @if($user->status == 'active') fa-ban @else fa-eye @endif"></i>
</button>