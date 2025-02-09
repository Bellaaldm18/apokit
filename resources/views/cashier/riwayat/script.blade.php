<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    })

    var table = $('#tabel-riwayat').DataTable({
        scrollX: true,
        processing: false,
        serverSide: false,
        ajax: "{{ url('load-data-riwayat') }}",
        columns: [
            {
                data: 'tgl_transaksi',
                name: 'Tanggal Transaksi',
                render: function(data, type, row) {
                    return formatDateToIndonesian(data)
                }
            },
            {
                data: 'no_transaksi',
                name: 'Nomor Transaksi',
            },
            //{
            //    data: '',
            //    name: 'Stok'
            //},
            {
                data: 'total_pembayaran',
                name: 'Total Pembayaran',
                render: function(data, type, row) {
                    return formatRupiah(data)
                }
            },
            {
                data: 'aksi',
                name: 'Aksi'
            },
        ],
        order: [
            // Mengurutkan berdasarkan kolom 'Nomor Transaksi' secara menurun (terbaru dulu)
            [1, 'desc']
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

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(number)
    }
</script>
