<div class="d-flex align-center">
    <a data-id="{{ $data->id }}" data-status="{{ $data->is_active }}" class="tombol-aktivasi {{ $data->is_active == 1 ? "btn-secondary" : "btn-success" }} btn btn-sm btn-icon btn-delete mr-2">
        {{ $data->is_active == 1 ? 'Non Aktifkan' : 'Aktifkan' }}
    </a>
    <a href="{{ route('user.edit', ['id' => $data->id]) }}" class="btn btn-sm btn-primary tombol-edit mr-2">
        Edit
    </a>
    <a data-id="{{ $data->id }}" title="Delete Data" class="btn btn-sm btn-icon btn-danger btn-delete">
        Hapus
    </a>
</div>
