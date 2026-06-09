<script>
    var table = $('#tabel-obat').DataTable({
        scrollX: true,
        ordering: false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/load-data-obat') }}",
        columns: [{
            data: null,
            name: 'Nomor',
            className: 'text-center align-center',
            render: function (data, type, row, meta) {
                // Menggunakan data.id untuk nomor increment
                return meta.row + 1;
            }
        },
        {
            data: 'nama',
            name: 'Nama',
            style: 'text-align: center'
        },
        {
            data: 'no_batch',
            name: 'Nomor Batch',
            style: 'text-align: center'
        },
        {
            data: 'tgl_kadaluarsa',
            name: 'Tanggal Kadaluarsa'
        },
        {
            data: 'stok',
            name: 'Kuantitas'
        },
        {
            data: 'harga_beli',
            name: 'Harga Beli'
        },
        {
            data: 'harga_jual',
            name: 'Harga Jual'
        },
        {
            data: 'catatan',
            name: 'Keterangan'
        },
        {
            data: 'aksi',
            name: 'Aksi'
        },
        ]
    })

    var swalInit = Swal.mixin({
        buttonsStyling: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light',
            denyButton: 'btn btn-light',
            input: 'form-control'
        }
    })

    $(document).ready(function() {
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swalInit.fire({
                text: 'Apakah data ini akan dihapus?',
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: 'manajemen-obat/' + id,
                        type: 'delete',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function() {
                            swalInit.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                            }).then((result) => {
                                table.clear().draw()
                                table.ajax.reload()
                            })
                        }
                    })
                }
            })
        })
    })
</script>
