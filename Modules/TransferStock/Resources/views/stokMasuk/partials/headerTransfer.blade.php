<div class="row mb-3">
    <div class="col-lg-8">
        <table class="w-100">
            <tr>
                <td colspan="2">
                    <h4><i class="fa-solid fa-globe"></i> No. Invoice:
                        {{ $row->kode_tstock }}</h4>
                </td>
            </tr>
            <tr>
                <td>
                    Dari Pengirim
                </td>
                <td>
                    Data Penerima
                </td>
            </tr>
            <tr>
                <td>
                    <strong>{{ $row->cabangPemberi->nama_cabang }}</strong>
                </td>
                <td>
                    <strong>{{ $row->cabangPenerima->nama_cabang }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    {{ $row->cabangPemberi->alamat_cabang }}
                </td>
                <td>
                    {{ $row->cabangPenerima->alamat_cabang }}
                </td>
            </tr>
            <tr>
                <td>
                    Telp/Wa:
                    {{ $row->cabangPemberi->nowa_cabang }}/{{ $row->cabangPemberi->notelpon_cabang }}
                </td>
                <td>
                    Telp/Wa:
                    {{ $row->cabangPenerima->nowa_cabang }}/{{ $row->cabangPenerima->notelpon_cabang }}
                </td>
            </tr>
            <tr>
                <td>
                    Email: {{ $row->cabangPemberi->email_cabang }}
                </td>
                <td>
                    Email: {{ $row->cabangPenerima->nowa_cabang }}
                </td>
            </tr>
            <tr>
                <td>
                    Kasir: {{ $row->users->name }}
                </td>
                <td>
                    Kasir: {{ $row->usersPenerima->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong> {{ $row->cabangPemberi->kota_cabang }} </strong>
                </td>
                <td>
                    <strong> {{ $row->cabangPenerima->kota_cabang }} </strong>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <table class="w-100">
            <tr>
                <td>Tanggal Kirim: </td>
                <td>{{ UtilsHelp::tanggalBulanTahunKonversi($row->tanggalkirim_tstock) }}</td>
            </tr>
            <tr>
                <td>Tanggal Diterima: </td>
                <td>{{ $row->tanggalditerima_tstock != null ? UtilsHelp::tanggalBulanTahunKonversi($row->tanggalditerima_tstock) : '-' }}
                </td>
            </tr>
            <tr>
                <td>Status: </td>
                <td>{{ $row->status_tstock }}</td>
            </tr>
        </table>
        <div class="mb-3 mt-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-menu me-1"></i> Aksi
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a target="_blank" href="#" class="dropdown-item d-flex align-items-center btn-print"
                        data-id="{{ $row->id }}">
                        <i class="bx bx-chevron-right scaleX-n1-rtl"></i>
                        Print
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
