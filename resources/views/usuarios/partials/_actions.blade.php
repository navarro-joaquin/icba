<a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
<button class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}"><i class="fas fa-trash"></i></button>
{{-- 
<a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
<form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display: inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger btn-eliminar" onclick="return confirm('¿Desea eliminar el usuario?')"><i class="fas fa-trash"></i></button>
</form> --}}
