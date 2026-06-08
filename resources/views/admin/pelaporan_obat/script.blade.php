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
                var short = nama.length > 12 ? nama.substring(0, 12) + '…' : nama;
                return '#' + (index + 1) + ' ' + short;
            });

            const fullLabels = res.map(function(item) { return item.nama_obat; });
            const data = res.map(function(item) { return item.total; });

            // Top 10 = merah, rank 11-20 = kuning
            const colors = data.map(function(_, index) {
                return index < 10 ? '#e74a3b' : '#f6c23e';
            });

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

            // Buat tabel legenda nama lengkap
            var legendHtml = '<p class="font-weight-bold mb-2">Keterangan Nama Lengkap:</p>';
            legendHtml += '<div class="row">';
            res.forEach(function(item, index) {
                var badgeColor = index < 10 ? '#e74a3b' : '#f6c23e';
                legendHtml += '<div class="col-md-6 col-lg-4 mb-1">';
                legendHtml += '<span style="color:' + badgeColor + '; font-weight:bold;">#' + (index + 1) + '</span> ';
                legendHtml += '<small>' + item.nama_obat + '</small>';
                legendHtml += '</div>';
            });
            legendHtml += '</div>';
            $('#legend-obat-terlaris').html(legendHtml);
        }
    })
</script>
