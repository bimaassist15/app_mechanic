<div class="row">
    <div class="col-lg-12">
        <h5>Laporan Laba Bersih Periode {{ $dari_tanggal != null ? UtilsHelp::formatDate($dari_tanggal) : '' }} &nbsp; -
            &nbsp;
            {{ $sampai_tanggal != null ? UtilsHelp::formatDate($sampai_tanggal) : '' }}</h5>
        @include('report::labaBersih.partials.pendapatan')
        @include('report::labaBersih.partials.pembelian')
        @include('report::labaBersih.partials.pengeluaran')
    </div>
</div>
