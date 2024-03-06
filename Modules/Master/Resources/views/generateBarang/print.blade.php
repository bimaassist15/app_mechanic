<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Generate Barcode</title>

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="grid-container">
        @foreach ($serialBarang as $item)
            <div class="grid-item">
                {!! '<img src="data:image/png;base64,' .
                    DNS1D::getBarcodePNG($item->nomor_serial_barang, 'C39+') .
                    '" alt="barcode" width="200px;" height="80px;"  />' !!} <br>
                <strong>{{ $item->nomor_serial_barang }}</strong>
            </div>
        @endforeach
    </div>
</body>

<script>
    window.print();
</script>

</html>
