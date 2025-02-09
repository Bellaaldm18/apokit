<div class="d-flex align-center">
    <a href="{{ route('manajemen-obat.edit', ['id' => $data->id]) }}" class="btn btn-sm btn-primary tombol-edit mr-2">
        Edit
    </a>
    <a data-id="{{ $data->id }}" title="Delete Data" class="btn btn-sm btn-icon btn-danger btn-delete">
        Delete
    </a>
</div>
