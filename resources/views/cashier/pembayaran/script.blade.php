<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    })

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(number);
    }

    function parseCurrencyString(currencyStr) {
        if (typeof currencyStr === 'string') {
            return parseFloat(currencyStr.replace(/[^\d]+/g, '').replace(',', '.'));
        } else if (typeof currencyStr === 'number') {
            return currencyStr;
        }
        return NaN;
    }

    function getKeranjang() {
        $.ajax({
            type: 'GET',
            url: "{{ url('keranjang') }}",
            success: function(response) {
                var keranjang = response.keranjang
                console.log(keranjang)
                tampilkanKeranjang(keranjang)
            },
            error: function(xhr, status, error) {
                console.error(error)
            }
        })
    }

    function tampilkanKeranjang(keranjang) {
        var tabelKeranjang = $('#tabel-keranjang tbody')
        tabelKeranjang.empty()

        var totalBarang = 0
        var totalPembayaran = 0

        keranjang.forEach(function(item, index) {
            var hargaSatuan = parseCurrencyString(item.harga)
            var subtotal = hargaSatuan * item.kuantitas
            totalBarang += parseInt(item.kuantitas)
            totalPembayaran += subtotal

            var baris = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.nama}</td>
                    <td>${item.nomor_batch}</td>
                    <td>${formatRupiah(hargaSatuan)}</td>
                    <td>${item.kuantitas} item</td>
                    <td>${formatRupiah(subtotal)}</td>
                </tr>
            `

            tabelKeranjang.append(baris)

            // Memperbarui teks total harga dan total kuantitas
            $('.bayar-hidden').val(totalPembayaran)
            $('.total-barang').text(totalBarang)
            $('.total-pembayaran').text(formatRupiah(totalPembayaran))
        })


    }

    // $('.bayar').on('input', function() {
    //     var inputHarga = $(this).val();
    //     var cleanedInputHarga = inputHarga.replace(/[^\d,]/g, '').replace(',', '.');
    //     var angka = parseFloat(cleanedInputHarga);
    //     var formattedValue = formatRupiah(angka);

    //     $(this).val(formattedValue);

    //     if (isNaN(angka) || angka < 0) {
    //         $('.kembalian').text('Tidak Valid');
    //     } else {
    //         var totalPembayaran = parseCurrencyString($('.total-pembayaran').text());
    //         var kembalian = angka - totalPembayaran;

    //         if (kembalian < 0) {
    //             $('.kembalian').text(formatRupiah(0));
    //         } else {
    //             $('.kembalian').text(formatRupiah(kembalian));
    //         }
    //     }
    // })

    $('.bayar').on('input', function () {
    var inputHarga = $(this).val();
    var cleanedInputHarga = inputHarga.replace(/[^\d,]/g, '').replace(',', '.');
    var angka = parseFloat(cleanedInputHarga);
    var formattedValue = formatRupiah(angka);

    $(this).val(formattedValue);

    var totalPembayaran = parseCurrencyString($('.total-pembayaran').text());
    var kembalian = angka - totalPembayaran;

    if (isNaN(angka) || angka < 0) {
        $('.kembalian').text('Tidak Valid');
        $('.bayar-hidden').val(0);
        $('.kembalian-hidden').val(0);
    } else {
        $('.bayar-hidden').val(Math.floor(angka));
        $('.kembalian-hidden').val(Math.max(0, Math.floor(kembalian)));

        if (kembalian < 0) {
            $('.kembalian').text(formatRupiah(0));
        } else {
            $('.kembalian').text(formatRupiah(kembalian));
        }
    }
});


    $(document).ready(function() {
        getKeranjang()
    })
</script>
