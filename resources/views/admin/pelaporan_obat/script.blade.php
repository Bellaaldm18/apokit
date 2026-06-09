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

    var table2 = $('#tabel-obat').DataTable({
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
        return dateStr
    }

    $.ajax({
        url: "{{ url('dashboard/grafik-obat-terlaris') }}",
        type: "GET",
        success: function (res) {
            // Label singkat (nomor urut + nama terpotong) untuk grafik
            const labels = res.map(function(item, index) {
                var nama = item.nama_obat;
                var short = nama.split(' ')[0];
                return '#' + (index + 1) + ' ' + short;
            });

            const fullLabels = res.map(function(item) { return item.nama_obat; });
            const data = res.map(function(item) { return Number(item.total); });

            // Hitung quintile dari data yang diurutkan naik
            var sorted = data.slice().sort(function(a, b) { return a - b; });
            var n = sorted.length;
            var q = [
                sorted[Math.floor(n * 0.2)] ?? sorted[n - 1],
                sorted[Math.floor(n * 0.4)] ?? sorted[n - 1],
                sorted[Math.floor(n * 0.6)] ?? sorted[n - 1],
                sorted[Math.floor(n * 0.8)] ?? sorted[n - 1],
            ];

            function getColor(value) {
                if (value <= q[0]) return '#f6c23e'; // kuning  - 20% terbawah
                if (value <= q[1]) return '#fd7e14'; // oranye  - 20-40%
                if (value <= q[2]) return '#e74a3b'; // merah   - 40-60%
                if (value <= q[3]) return '#4e73df'; // biru    - 60-80%
                return '#1cc88a';                     // hijau   - 20% teratas
            }

            const colors = data.map(function(val) { return getColor(val); });

            new Chart(document.getElementById('chartObatTerlaris'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: data,
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    return fullLabels[tooltipItems[0].dataIndex];
                                },
                                label: function(tooltipItem) {
                                    return 'Terjual: ' + tooltipItem.raw + ' unit';
                                }
                            }
                        }
                    }
                }
            });

            // Keterangan warna kuintil dengan range aktual
            var colorLegend = [
                { color: '#f6c23e', label: 'Terendah (0%–20%)' },
                { color: '#fd7e14', label: 'Rendah (20%–40%)' },
                { color: '#e74a3b', label: 'Sedang (40%–60%)' },
                { color: '#4e73df', label: 'Tinggi (60%–80%)' },
                { color: '#1cc88a', label: 'Terlaris (80%–100%)' },
            ];
            var colorLegendHtml = '<div class="d-flex flex-wrap mb-3">';
            colorLegend.forEach(function(c) {
                colorLegendHtml += '<span class="mr-3 mb-1">'
                    + '<span style="display:inline-block;width:12px;height:12px;background:' + c.color + ';border-radius:2px;margin-right:4px;vertical-align:middle;"></span>'
                    + '<small>' + c.label + '</small>'
                    + '</span>';
            });
            colorLegendHtml += '</div>';

            // // Tabel legenda nama lengkap
            // var legendHtml = colorLegendHtml;
            // legendHtml += '<p class="font-weight-bold mb-2">Keterangan Nama Lengkap:</p>';
            // legendHtml += '<div class="row">';
            // res.forEach(function(item, index) {
            //     var badgeColor = getColor(item.total);
            //     legendHtml += '<div class="col-md-6 col-lg-4 mb-1">';
            //     legendHtml += '<span style="color:' + badgeColor + '; font-weight:bold;">#' + (index + 1) + '</span> ';
            //     legendHtml += '<small>' + item.nama_obat + ' <span class="text-muted">(' + item.total + ' unit)</span></small>';
            //     legendHtml += '</div>';
            // });
            // legendHtml += '</div>';
            $('#legend-obat-terlaris').html(colorLegendHtml);
        }
    })
</script>
