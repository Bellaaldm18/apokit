<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });

    var table = $('#tabel-user').DataTable({
        scrollX: true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/load-data-user') }}",
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
            data: 'role',
            name: 'Role',
            style: 'text-transform: capitalize'
        },
        {
            data: 'nama',
            name: 'Nama Lengkap',
            style: 'text-align: center'
        },
        {
            data: 'email',
            name: 'Email',
            style: 'text-align: center'
        },
        {
            data: 'no_tlpn',
            name: 'Nomor Telepon'
        },
        {
            data: 'aksi',
            name: 'Aksi'
        }],
        columnDefs: [{
            orderable: false,
            targets: 5
        }]
    })

    var swalInit = Swal.mixin({
        buttonsStyling: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light mr-2',
            denyButton: 'btn btn-light',
            input: 'form-control'
        }
    })

    $(document).ready(function() {
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swalInit.fire({
                title: 'Yakin data akan dihapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus!',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: 'dashboard/user/' + id,
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

        $('body').on('click', '.tombol-aktivasi', function(e) {
            e.preventDefault();
            var tombolaktivasi = $(this);
            tombolaktivasi.addClass('disabled')
                .prop('disabled', true)
                .html('<i class="icon-spinner2 spinner"></i>');
            var id = $(this).data('id');
            var status = $(this).data('status');
            var msg = '';
            var msgTitle = '';
            if (status == '0') {
                msgTitle = 'Aktivasi User';
                msg = 'Data user akan diaktifkan ?';
            } else if (status == '1') {
                msgTitle = 'Aktivasi User';
                msg = 'Data user akan dinonaktifkan ?';
            }
            swalInit.fire({
                title: msgTitle,
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    aktivasi(id, status);
                } else {
                    if (tombolaktivasi.data('status') == '0') {
                        tombolaktivasi.removeClass('disabled')
                            .prop('disabled', false)
                            .html('<p>Aktifkan</p>');
                    } else if (tombolaktivasi.data('status') == '1') {
                        tombolaktivasi.removeClass('disabled')
                            .prop('disabled', false)
                            .html('<p>Non Aktifkan</p>');
                    }
                }
            });
        });
    })

    function aktivasi(id, status) {
        var aktivasi = '';
        if (status == '0') {
            aktivasi = '1';
        } else {
            aktivasi = '0';
        }
        $.ajax({
            url: "{{ url('dashboard/aktivasi-user') }}" + '/' + id,
            type: "PUT",
            data: {
                status: aktivasi,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                var text = '';
                if (status == 'aktif') {
                    text = 'NonAktifkan';
                } else if (status == 'non aktif') {
                    text = 'Aktifkan';
                }
                $('.tombol-aktivasi').removeClass('disabled')
                    .prop('disabled', false)
                    .html(text);
                if (response.success == true) {
                    swalInit.fire({
                        title: 'Sukses!',
                        text: 'Berhasil',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        table.ajax.reload();
                    });
                } else {
                    swalInit.fire({
                        title: 'Gagal!',
                        text: 'Gagal',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }
</script>
