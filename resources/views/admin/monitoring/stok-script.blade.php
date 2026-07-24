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
        drawCallback: function() {
            var api = this.api();
            var start = api.page.info().start;
            api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                cell.innerHTML = start + i + 1;
            });
        },
        columns: [
            { data: null, className: 'text-center' },
            { data: 'nama', className: 'text-left' },
            { data: 'no_batch', className: 'text-left' },
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
                className: 'text-left',
                render: function(data) { return formatDateToIndonesian(data); }
            },
            {
                data: 'harga_jual',
                className: 'text-right',
                render: function(data) { return formatRupiah(data); }
            },
        ]
    });
</script>
