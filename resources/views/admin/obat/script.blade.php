<script>
    var table = $('#tabel-obat').DataTable({
        scrollX: true,
        order: [],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/load-data-obat') }}",
        columns: [
        {
            data: null,
            name: 'Nomor',
            className: 'text-center align-center',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'nama',
            name: 'Nama',
            className: 'text-left',
        },
        {
            data: 'is_obat_keras',
            name: 'Jenis',
            className: 'text-center',
            render: function(data) {
                if (data == 1) {
                    return '<span class="badge badge-danger">Obat Keras</span>';
                }
                return '<span class="badge badge-success">Obat Bebas</span>';
            }
        },
        {
            data: 'no_batch',
            name: 'Nomor Batch',
            className: 'text-left',
        },
        {
            data: 'tgl_kadaluarsa',
            name: 'Tanggal Kadaluarsa',
            className: 'text-left',
        },
        {
            data: 'stok',
            name: 'Stok',
            className: 'text-center',
            render: function(data) {
                if (data <= 5) {
                    return '<span class="badge badge-danger">' + data + '</span>';
                } else if (data <= 20) {
                    return '<span class="badge badge-warning">' + data + '</span>';
                }
                return '<span class="badge badge-success">' + data + '</span>';
            }
        },
        {
            data: 'harga_beli',
            name: 'Harga Beli',
            className: 'text-right',
            render: function(data) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data);
            }
        },
        {
            data: 'harga_jual',
            name: 'Harga Jual',
            className: 'text-right',
            render: function(data) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data);
            }
        },
        {
            data: 'komposisi',
            name: 'Komposisi',
            className: 'text-left',
            render: function(data) {
                if (!data) return '-';
                return data.length > 40 ? '<span title="' + data + '">' + data.substring(0, 40) + '...</span>' : data;
            }
        },
        {
            data: 'catatan',
            name: 'Keterangan',
            className: 'text-left',
            render: function(data) {
                return data || '-';
            }
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
