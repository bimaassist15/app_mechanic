@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/x-icon"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/img/favicon/favicon.ico" />

    <title>Print Nota Servis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        #print_nota {
            width: 8cm;
        }

        .text-center {
            text-align: center;
        }

        .fs15 {
            font-size: 15px;
        }

        .fs14 {
            font-size: 14px;
        }

        .pb1 {
            padding-bottom: 1px;
        }

        .pb10 {
            padding-bottom: 10px;
        }

        .pt10 {
            padding-top: 10px;
        }

        .fs20 {
            font-size: 20px;
        }

        .pb5 {
            padding-bottom: 5px;
        }

        .fs60 {
            font-size: 60px;
        }

        .fw700 {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <section id="print_nota">
        <table style="width: 100%;" class="text-center">
            <tr>
                <td class="pb1 pt10"><strong class="fs15">{{ $myCabang->bengkel_cabang }}</strong></td>
            </tr>
            <tr>
                <td class="pb1">
                    <span class="fs14">{{ $myCabang->alamat_cabang }}</span>
                </td>
            </tr>
            <tr>
                <td class="pb10">
                    <span class="fs14">
                        {{ $myCabang->kota_cabang }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="pb10">
                    <hr>
                </td>
            </tr>
            <tr>
                <td class="pb5">
                    <h4 class="fs20">Nomor Antrian</h4>
                </td>
            </tr>
            <tr>
                <td class="pb5">
                    <span class="fs60 fw700">{{ $penerimaanServis->noantrian_pservis }}</span>
                </td>
            </tr>
            <tr>
                <td class="pb1">
                    <span class="fs14">Tipe Servis: {{ $penerimaanServis->tipe_pservis }}</span>
                </td>
            </tr>
            <tr>
                <td class="pb10">
                    <span class="fs14">
                        {{ UtilsHelp::tanggalBulanTahunKonversi($penerimaanServis->created_at) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="pb10">
                    <hr>
                </td>
            </tr>
            <tr>
                <td class="pb5">
                    <strong>
                        Cek Servis Online
                    </strong>
                </td>
            </tr>
            <tr>
                <td class="pb5">
                    {!! QrCode::generate($penerimaanServis->id . '/' . $penerimaanServis->noantrian_pservis) !!}
                </td>
            </tr>
            <tr>
                <td class="pb5">
                    <span class="fs14">Terima Kasih</span>
                </td>
            </tr>
            <tr>
                <td class="pb10">
                    <span class="fs14">
                        Powered By {{ UtilsHelp::createdApp() }}
                    </span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
