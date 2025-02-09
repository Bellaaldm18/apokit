<script>
    var table = $('#tabel-kadaluarsa').DataTable({
        scrollX: true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/obat-kadaluarsa') }}",
        columns: [
            {
                data: 'nama',
                name: 'Nama Obat',
                className: 'text-center'
            },
            {
                data: 'no_batch',
                name: 'Nomor Batch',
                className: 'text-center'
            },
            {
                data: 'tgl_kadaluarsa',
                name: 'Tanggal Kadaluarsa',
                className: 'text-center',
                render: function(data, type, row) {
                    return formatDateToIndonesian(data)
                }
            },
            {
                data: 'stok',
                name: 'Stok Saat Ini',
                className: 'text-center'
            },
        ],
        order: [
            [2, 'asc']
        ]

    })

    var table = $('#tabel-obat').DataTable({
        scrollX: true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/obat-terlaris') }}",
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
                data: 'nama_obat',
                name: 'Nama Obat',
                className: 'text-center'
            },
            {
                data: 'no_batch',
                name: 'Nomor Batch',
                className: 'text-center'
            },
            {
                data: 'total_penjualan',
                name: 'Total Penjualan',
                className: 'text-center',
            },
            {
                data: 'stok',
                name: 'Stok Saat Ini',
                className: 'text-center'
            },
        ]
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

</script>
