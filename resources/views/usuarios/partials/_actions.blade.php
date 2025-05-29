<a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
<form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display: inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Desea eliminar el usuario?')"><i class="fas fa-trash"></i></button>
</form>
