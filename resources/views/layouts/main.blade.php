{{-- //pages-blank --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

     <!-- Title dan Meta Tags -->
     <title>{{ $title ?? '' }} Point Of Sales</title>
    <meta name="description" content="{{ $description ?? 'Deskripsi default aplikasi Anda' }}">
    <meta name="keywords" content="{{ $keywords ?? 'keyword1, keyword2, keyword3' }}">
    <meta name="author" content="Nama Perusahaan/Developer">

    <!-- <title>{{ $title ?? '' }}</title> -->
    <!-- <meta content="" name="description"> -->
    <!-- <meta content="" name="keywords"> -->

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')

    <!-- ======= Header ======= -->
    @include('layouts.inc.header');

    <!-- ======= Sidebar ======= -->
    @include('layouts.inc.sidebar');

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>@yield('title')</h1>
        </div><!-- End Page Title -->

        @yield('content')



    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <!-- <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script> -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script> -->
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>


    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9']) -->


    {{-- script sales --}}
    <script>
        $('.datatablebutton').DataTable({
            dom: 'B',
            "bPaginate": false,
            buttons: [
                'copy', 'csv', 'excel', 'print'
            ]
        });

        function formatRupiah(number) {
            const formatted = number.toLocaleString("id", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });
            return formatted;
        }

        $('#category_id').change(function() {
            let cat_id = $(this).val(),
                option = `<option value="">Select One</option>`
            $.ajax({
                url: '/get-product/' + cat_id,
                type: 'GET',
                dataType: 'json',
                success: function(resp) {
                    // console.log("response", resp);
                    $.each(resp.data, function(index, value) {
                        option +=
                            `<option
                                data-img="${value.product_photo}" data-price="${value.product_price}"
                                value ="${value.id}">${value.product_name}</option>`;
                    });

                    $('#product_id').html(option)
                }
            });
        });

        $(".add-row").click(function() {

            let tbody = $('tbody');
            let selectedOption = $('#product_id').find('option:selected')
            let namaProduk = selectedOption.text();
            let productId = selectedOption.val();
            let photoProduct = selectedOption.data('img');
            let productPrice = parseInt(selectedOption.data('price')) || 0;

            if ($('#category_id').val() == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Category Null!",
                    confirmButtonColor: "#00000",
                });
                return false;
            }

            if ($('#product_id').val() == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Product Null!",
                });
                return false;
            }

            let newRow = "<tr>";

            newRow +=
                `<td class='text-center'><img src="{{ asset('storage/') }}/${photoProduct}" width="120" alt="Image Product"></td>`

            newRow += `<td>${namaProduk}<input type='hidden' name='product_id[]' value='${productId}'></td>`

            newRow +=
                `<td width='110'><input type='number' name='qty[]' class='qty form-control' width='100' value='1'></td>`
            newRow +=
                `<td><input type='hidden' name='order_price[]' value='${productPrice}'><span class='price' data-price=${productPrice}>${formatRupiah(productPrice)}</span></td>`
            newRow +=
                `<td><input type='hidden' class='subtotal_input' name='order_subtotal[]' value='${productPrice}'><span class='subtotal'>${formatRupiah(productPrice)}</span></td>`
            newRow +=
                `<td><button type='button' class='btn btn-danger btn-sm remove' id='remove'><i class='bi bi-trash'></i></button></td>`
            newRow += "</tr>"

            tbody.append(newRow);

            // calculateSubTotal();

            clearAll();

            $('.qty').off().on('input', function() {

                let row = $(this).closest('tr');
                let qty = parseInt($(this).val()) || 0;
                let price = parseInt(row.find('.price').data('price')) || 0;
                console.log(price);
                let total = qty * price;

                row.find('.subtotal').text(formatRupiah(total));
                row.find('.subtotal_input').val(total);
                calculateSubTotal();
            })

            // hapus product list by id
            $('.remove').click(function(event) {
                event.preventDefault();
                $(this).closest('tr').remove();
                calculateSubTotal();
            });
        });


        function clearAll() {
            $('#category_id').val("");
            $('#product_id').val("");
        }

        function calculateSubTotal() {
            let grandTotal = 0;
            $('.subtotal').each(function() {
                let total = parseInt($(this).text().replace(/\./g, ''));
                grandTotal += total;
            });

            $('.grandtotal').text(formatRupiah(grandTotal));
            $('input[name="grandtotal"]').val(grandTotal);
        }
    </script>
</body>

</html>
