<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>aruji</title>
    <link rel="shortcut icon" type="image/png" href="{{ url('images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ url('css/styles.min.css') }}" />

    <script src="{{ url('libs/jquery/dist/jquery.min.js')}}"></script>
    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }
    </script>

    <style>
        .custom-max-height {
            max-height: 59vh;
            /* Sesuaikan dengan tinggi yang diinginkan */

            /* Menambahkan scroll jika konten melebihi max-height */
        }
    </style>
</head>