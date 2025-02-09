<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    })

    var table = $('#tabel-obat').DataTable({
        scrollX: true,
        processing: false,
        serverSide: false,
        ajax: "{{ url('search-obat') }}",
        columns: [{
                data: 'nama',
                name: 'Nama Obat',
                className: 'nama-produk',
                render: function(data, type, row) {
                    // Memisahkan nama obat dan nomor batch untuk tampilan di tabel
                    var displayNama = row.nama;
                    if (row.no_batch) {
                        displayNama += '<br>(' + row.no_batch + ')';
                    }
                    return displayNama;
                }
            },
            {
                data: 'no_batch',
                name: 'Nomor Batch',
                className: 'no-batch d-none',
            },
            {
                data: 'stok',
                name: 'Stok'
            },
            {
                data: 'harga_jual',
                name: 'Harga',
                className: 'harga-produk',
                render: function(data, type, row) {
                    return formatRupiah(data)
                }
            },
            {
                data: 'aksi',
                name: 'Aksi'
            },
        ]
    })

    $('#search-input').on('keyup', function() {
        table.search(this.value).draw()
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

    function parseCurrencyString(currencyStr) {
        if (typeof currencyStr === 'string') {
            return parseFloat(currencyStr.replace(/[^\d]+/g, '').replace(',', '.'))
        } else if (typeof currencyStr === 'number') {
            return currencyStr
        }
        return NaN
    }


    var keranjang = []

    // Menambahkan item di keranjang
    function tambahKeranjang(id, nama, no_batch, harga) {
        // Cek item ada atau tidak
        var checkItem = keranjang.find(function(item) {
            return item.id === id
        })

        var displayNama = nama.replace(/\([^)]*\)/, '').trim()

        if (checkItem) {
            checkItem.kuantitas++
        } else {
            keranjang.push({
                id: id,
                nama: displayNama,
                harga: harga, // Pass the numeric price value here
                kuantitas: 1,
                nomor_batch: no_batch
            })
        }

        perbaruiKeranjang()
    }

    function simpanKeranjang(dataKeranjang) {
        $.ajax({
            type: "POST",
            url: "{{ url('simpan-keranjang') }}",
            data: {
                keranjang: keranjang
            },
            success: function(response) {
                console.log(response.message)
            },
            error: function(xhr, status, error) {
                console.error(error)
            }
        })
    }

    // Memperbarui tampilan tabel keranjang
    function perbaruiKeranjang() {
        var tabelKeranjang = $('#tabel-keranjang tbody')
        tabelKeranjang.empty()

        var totalHarga = 0

        keranjang.forEach(function(item, index) {
            var harga = parseCurrencyString(item.harga)
            var subtotal = harga * item.kuantitas
            totalHarga += subtotal
            var baris = `
            <tr>
                <td>${index + 1}</td>
                <td class="nama-produk">${item.nama}</td>
                <td class="harga-produk">${formatRupiah(item.harga)}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-kurang" data-id="${item.id}"><i class="fas fa-minus"></i></button>
                        <span class="input-group-text bg-white">${item.kuantitas}</span>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-tambah" data-id="${item.id}"><i class="fas fa-plus"></i></button>
                    </div>
                </td>
                <td class="total-harga">${formatRupiah(subtotal)}</td>
                <td>
                    <button class="btn btn-danger btn-hapus" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>

            `
            tabelKeranjang.append(baris)

            // Menghitung total nominal
            var totalNominal = keranjang.reduce(function(total, item) {
                var harga = parseCurrencyString(item.harga)
                return total + harga * item.kuantitas
            }, 0)

            // Memperbarui tampilan total nominal
            $('#total-nominal').text(formatRupiah(totalNominal))

            // Menghitung total kuantitas
            var totalKuantitas = keranjang.reduce(function(total, item) {
                return total + item.kuantitas
            }, 0)

            // Memperbarui teks total harga dan total kuantitas
            $('#total-harga-teks').text(`Total Harga (${totalKuantitas} Barang)`)
            $('#total-harga').text(formatRupiah(totalNominal))

            simpanKeranjang(keranjang)
        })
    }


    $(document).on('click', '.tombol-tambah', function(e) {
        e.preventDefault()
        var id = $(this).data('id')
        var nama = $(this).closest('tr').find('.nama-produk').text()
        var no_batch = $(this).closest('tr').find('.no-batch').text()
        var hargaStr = $(this).closest('tr').find('.harga-produk').text()
        var harga = parseCurrencyString(hargaStr)

        if (!isNaN(harga)) {
            tambahKeranjang(id, nama, no_batch, harga)
        }
    })

    $(document).on('click', '.btn-kurang', function() {
        var id = $(this).data('id')
        var item = keranjang.find(function(item) {
            return item.id === id
        })

        if (item && item.kuantitas > 1) {
            item.kuantitas--
            perbaruiKeranjang()
        }
    })

    $(document).on('click', '.btn-tambah', function() {
        var id = $(this).data('id')
        var item = keranjang.find(function(item) {
            return item.id === id
        })

        if (item) {
            item.kuantitas++
            perbaruiKeranjang()
        }
    })

    $(document).on('click', '.btn-hapus', function() {
        var id = $(this).data('id')
        keranjang = keranjang.filter(function(item) {
            return item.id !== id
        })
        perbaruiKeranjang()
    })

    $(document).on('click', '#btn-bayar-sekarang', function() {
        var dataKeranjang = []
        $('#tabel-keranjang tbody tr').each(function(index, row) {
            var id = $(row).data('id')
            var nama = $(row).find('.nama-produk').text()
            var harga = $(row).find('.harga-produk').text()
            var kuantitas = $(row).find('.kuantitas').val()
            var no_batch = $(row).data('nomor_batch')
            dataKeranjang.push({
                id: id,
                nama: nama,
                harga: harga,
                kuantitas: kuantitas,
                no_batch: no_batch
            })
        })

        simpanKeranjang(dataKeranjang)

        window.location.href = "{{ url('pembayaran') }}"
    })
</script>
