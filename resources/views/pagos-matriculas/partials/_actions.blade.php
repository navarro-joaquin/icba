@can('editar pagos-matriculas')
    <a href="{{ route('pagos-matriculas.edit', $pago_matricula) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@endcan

@can('eliminar pagos-matriculas')
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $pago_matricula->id }}">
        <i class="fas fa-trash"></i>
    </button>
@endcan
