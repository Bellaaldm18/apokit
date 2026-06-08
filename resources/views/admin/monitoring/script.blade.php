<script>
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(number);
    }

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

    $('#tabel-stok-rendah').DataTable({
        scrollX: true,
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/monitoring-stok-rendah') }}",
        order: [[3, 'asc']],
        columns: [
            { data: null, className: 'text-center', render: function(d,t,r,m){ return m.row+1; } },
            { data: 'nama', className: 'text-center' },
            { data: 'no_batch', className: 'text-center' },
            {
                data: 'stok',
                className: 'text-center',
                render: function(data) {
                    var cls = data <= 5 ? 'badge-danger' : 'badge-warning';
                    return '<span class="badge ' + cls + '">' + data + '</span>';
                }
            },
            {
                data: 'tgl_kadaluarsa',
                className: 'text-center',
                render: function(data) { return formatDateToIndonesian(data); }
            },
            {
                data: 'harga_jual',
                className: 'text-center',
                render: function(data) { return formatRupiah(data); }
            },
        ]
    });

    $('#tabel-kadaluarsa-monitor').DataTable({
        scrollX: true,
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" },
        processing: false,
        serverSide: false,
        ajax: "{{ url('dashboard/monitoring-kadaluarsa') }}",
        order: [[4, 'asc']],
        columns: [
            { data: null, className: 'text-center', render: function(d,t,r,m){ return m.row+1; } },
            { data: 'nama', className: 'text-center' },
            { data: 'no_batch', className: 'text-center' },
            {
                data: 'stok',
                className: 'text-center',
                render: function(data) {
                    var cls = data <= 5 ? 'badge-danger' : (data <= 20 ? 'badge-warning' : 'badge-success');
                    return '<span class="badge ' + cls + '">' + data + '</span>';
                }
            },
            {
                data: 'tgl_kadaluarsa',
                className: 'text-center',
                render: function(data) { return formatDateToIndonesian(data); }
            },
            {
                data: 'tgl_kadaluarsa',
                className: 'text-center',
                render: function(data) {
                    var today = new Date();
                    var exp = new Date(data);
                    today.setHours(0,0,0,0);
                    exp.setHours(0,0,0,0);
                    var diffDays = Math.ceil((exp - today) / (1000 * 60 * 60 * 24));
                    if (diffDays < 0) {
                        return '<span class="badge badge-danger">Sudah Kadaluarsa</span>';
                    } else if (diffDays === 0) {
                        return '<span class="badge badge-warning">Hari Ini</span>';
                    } else if (diffDays <= 30) {
                        return '<span class="badge badge-danger">' + diffDays + ' Hari Lagi</span>';
                    } else {
                        return '<span class="badge badge-info">' + diffDays + ' Hari Lagi</span>';
                    }
                }
            },
        ]
    });
</script>
