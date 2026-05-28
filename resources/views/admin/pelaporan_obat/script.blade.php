<script>
    var table = $('#tabel-kadaluarsa').DataTable({
        scrollX: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/obat-kadaluarsa') }}",
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
                render: function(data) {
                    return formatDateToIndonesian(data)
                }
            },
            {
                data: 'tgl_kadaluarsa',
                name: 'Sisa Hari',
                className: 'text-center',
                render: function(data) {

                    const today = new Date()
                    const expiredDate = new Date(data)

                    // reset jam agar hitungan hari akurat
                    today.setHours(0,0,0,0)
                    expiredDate.setHours(0,0,0,0)

                    const diffTime = expiredDate - today
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

                    if (diffDays < 0) {
                        return `<span class="badge bg-danger text-white">Sudah Kadaluarsa</span>`
                    } else if (diffDays === 0) {
                        return `<span class="badge bg-warning text-white">Hari Ini</span>`
                    } else {
                        return `<span class="badge bg-info text-white">${diffDays} Hari Lagi</span>`
                    }
                }
            },
            {
                data: 'stok',
                name: 'Stok Saat Ini',
                className: 'text-center'
            },
        ],
        order: [
            [3, 'asc']
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

    $.ajax({
    url: "{{ url('dashboard/grafik-obat-terlaris') }}",
    type: "GET",
    success: function (res) {

        const labels = res.map(item => item.nama_obat)
        const data = res.map(item => item.total)

        new Chart(document.getElementById('chartObatTerlaris'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Obat Terlaris (30 Hari)',
                    data: data,
                    backgroundColor: '#1cc88a'
                }]
            }
        })

    }
})
</script>
