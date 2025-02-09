<script>
    var table = $('#tabel-keuangan').DataTable({
        scrollX: true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: {
            url: "{{ url('dashboard/load-laporan-bulan') }}",
            data: function (d) {
                d.bulan = String(dropdownBulan.val()); // Mengambil nilai bulan dari dropdown
            }
        },
        columns: [
            {
                data: null,
                name: 'Nomor',
                className: 'text-center align-center',
                render: function (data, type, row, meta) {
                    // Menggunakan data.id untuk nomor increment
                    return meta.row + 1;
                }
            },
            {
                data: 'no_transaksi',
                name: 'no_transaksi',
                className: 'text-center'
            },
            {
                data: 'tgl_transaksi',
                name: 'tgl_transaksi',
                className: 'text-center',
                render: function(data, type, row) {
                    return formatDateToIndonesian(data)
                }
            },
            {
                data: 'total_pembayaran',
                name: 'total_transaksi',
                className: 'text-center',
                render: function(data, type, row) {
                    return formatRupiah(data)
                }
            },
        ]
    })

    $(document).ready(function() {
        $('body').on('click', '.export', function(e){
            e.preventDefault()
            var selectedBulan = dropdownBulan.val();

            window.location.href = "{{ url('dashboard/export-laporan-bulanan') }}?bulan=" + selectedBulan;
        })
    })

    var dropdownBulan = $('#bulan')

    var bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    for (var i = 0; i < bulan.length; i++) {
        var option = $('<option></option>')
        option.val((i + 1).toString().padStart(2, '0'))
        option.text(bulan[i])
        dropdownBulan.append(option)
    }


    dropdownBulan.on('change', function() {
        console.log(dropdownBulan.val())
        table.ajax.reload()
    })

    function formatDateToIndonesian(dateStr) {
        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ]

        const parts = dateStr.split("-")
        if (parts.length === 3) {
            const year = parts[0]
            const month = parseInt(parts[1]) - 1
            const day = parts[2]
            return day + " " + months[month] + " " + year
        }
        return dateStr // Return the original date if the format is invalid
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(number)
    }

</script>
