<script>
    var table = $('#tabel-biaya').DataTable({
        scrollX: true,
        order: [],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/load-data-biaya') }}",
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
            data: 'tanggal',
            name: 'Tanggal',
            className: 'text-left',
            render: function(data) {
                return formatDateToIndonesian(data);
            }
        },
        {
            data: 'nama_biaya',
            name: 'Nama Biaya',
            className: 'text-left',
        },
        {
            data: 'kategori',
            name: 'Kategori',
            className: 'text-center',
            render: function(data) {
                if (data === 'operasional') {
                    return '<span class="badge badge-warning">Operasional</span>';
                }
                return '<span class="badge badge-danger">Non-Operasional</span>';
            }
        },
        {
            data: 'jumlah',
            name: 'Jumlah',
            className: 'text-right',
            render: function(data) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data);
            }
        },
        {
            data: 'keterangan',
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

    function formatDateToIndonesian(dateStr) {
        if (!dateStr) return '-';
        const months = ["Januari","Februari","Maret","April","Mei","Juni",
            "Juli","Agustus","September","Oktober","November","Desember"];
        const parts = dateStr.split("-");
        if (parts.length === 3) {
            return parts[2] + " " + months[parseInt(parts[1]) - 1] + " " + parts[0];
        }
        return dateStr;
    }

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
                        url: 'biaya-operasional/' + id,
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
