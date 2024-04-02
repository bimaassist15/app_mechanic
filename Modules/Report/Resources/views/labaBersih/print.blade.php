<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Laba Bersih</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        section#print {
            width: 21cm;
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <section id="print">
        <h3>Laporan Laba Bersih Periode {{ $dari_tanggal != null ? UtilsHelp::formatDate($dari_tanggal) : '' }}
            &nbsp; -
            &nbsp;
            {{ $sampai_tanggal != null ? UtilsHelp::formatDate($sampai_tanggal) : '' }}</h5>
            @include('report::labaBersih.partials.pendapatan')
            @include('report::labaBersih.partials.pembelian')
            @include('report::labaBersih.partials.pengeluaran')
    </section>
</body>

</html>
