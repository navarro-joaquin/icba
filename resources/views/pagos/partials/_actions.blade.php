@can('editar pagos')
    <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar pagos')
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $pago->id }}">
        <i class="fas fa-trash"></i>
    </button>
@endcan
