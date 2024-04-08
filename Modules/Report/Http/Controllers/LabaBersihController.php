<?php

namespace Modules\Report\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PenerimaanServis;
use App\Models\Penjualan;
use App\Models\TransaksiPendapatan;
use App\Models\TransaksiPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LabaBersihController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');

            // penjualan
            $getPenjualan = new Penjualan();
            $dataPenjualan = $getPenjualan->dataTable();
            if ($dari_tanggal != '') {
                $dataPenjualan = $dataPenjualan->whereDate('created_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != '') {
                $dataPenjualan = $dataPenjualan->whereDate('updated_at', '<=', $sampai_tanggal);
            }
            $sumBayarPenjualan = $dataPenjualan->sum('bayar_penjualan');
            $sumKembalianPenjualan = $dataPenjualan->sum('kembalian_penjualan');
            $sumTotalPenjualan = $sumBayarPenjualan - $sumKembalianPenjualan;

            // transaksi servis
            $getTransaksiServis = new PenerimaanServis();
            $dataTransaksiServis = $getTransaksiServis->dataTable()->where('status_pservis', '!=', 'estimasi servis');
            if ($dari_tanggal != '') {
                $dataTransaksiServis->whereDate('created_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != '') {
                $dataTransaksiServis->whereDate('updated_at', '<=', $sampai_tanggal);
            }
            $dataTransaksiServis = $dataTransaksiServis
                ->whereIn('status_pservis', ['sudah diambil', 'komplain garansi']);

            $sumBayarServis = $dataTransaksiServis->sum('bayar_pservis');
            $sumKembalianServis = $dataTransaksiServis->sum('kembalian_pservis');
            $sumTotalTransaksiServis = $sumBayarServis - $sumKembalianServis;

            // biaya kategori pendapatan lainnya
            $transaksiPendapatan = TransaksiPendapatan::dataTable()->select('kategori_pendapatan_id', 'kategori_pendapatan.nama_kpendapatan', DB::raw('sum(jumlah_tpendapatan) as jumlah_tpendapatan'))
                ->join('kategori_pendapatan', 'transaksi_pendapatan.kategori_pendapatan_id', '=', 'kategori_pendapatan.id')
                ->groupBy('kategori_pendapatan_id', 'kategori_pendapatan.nama_kpendapatan');

            if ($dari_tanggal != '') {
                $transaksiPendapatan = $transaksiPendapatan->whereDate('tanggal_tpendapatan', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != '') {
                $transaksiPendapatan = $transaksiPendapatan->whereDate('tanggal_tpendapatan', '<=', $sampai_tanggal);
            }
            $dataTransaksiPendapatan = $transaksiPendapatan->get();
            $sumDataPendapatan = $dataTransaksiPendapatan->sum('jumlah_tpendapatan');
            $totalPendapatan = $sumTotalPenjualan + $sumTotalTransaksiServis + $sumDataPendapatan;
            // end biaya kategori pendapatan lainnya

            // pembelian
            $getPembelian = new Pembelian();
            $dataPembelian = $getPembelian->dataTable();
            if ($dari_tanggal != '') {
                $dataPembelian = $dataPembelian->whereDate('created_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != '') {
                $dataPembelian = $dataPembelian->whereDate('updated_at', '<=', $sampai_tanggal);
            }

            $sumBayarPembelian = $dataPembelian->sum('bayar_pembelian');
            $sumKembalianPembelian = $dataPembelian->sum('kembalian_pembelian');
            $sumTotalPembelian = $sumBayarPembelian - $sumKembalianPembelian;
            // end pembelian

            // laba / rugi koto
            $labaRugiKoto = $totalPendapatan - $sumTotalPembelian;
            // end laba / rugi koto

            // biaya kategori pendapatan lainnya
            $transaksiPengeluaran = TransaksiPengeluaran::dataTable()->select('kategori_pengeluaran_id', 'kategori_pengeluaran.nama_kpengeluaran', DB::raw('sum(jumlah_tpengeluaran) as jumlah_tpengeluaran'))
                ->join('kategori_pengeluaran', 'transaksi_pengeluaran.kategori_pengeluaran_id', '=', 'kategori_pengeluaran.id')
                ->groupBy('kategori_pengeluaran_id', 'kategori_pengeluaran.nama_kpengeluaran');

            if ($dari_tanggal != '') {
                $transaksiPengeluaran = $transaksiPengeluaran->whereDate('tanggal_tpengeluaran', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != '') {
                $transaksiPengeluaran = $transaksiPengeluaran->whereDate('tanggal_tpengeluaran', '<=', $sampai_tanggal);
            }
            $dataTransaksiPengeluaran = $transaksiPengeluaran->get();
            $sumDataPengeluaran = $dataTransaksiPengeluaran->sum('jumlah_tpengeluaran');
            $totalPengeluaran = $sumDataPengeluaran;
            // end biaya kategori pengeluaran lainnya

            // laba bersih
            $labaBersih = $labaRugiKoto - $totalPengeluaran;
            // end laba bersih

            $data = [
                'dari_tanggal' => $dari_tanggal,
                'sampai_tanggal' => $sampai_tanggal,
                'pendapatan' =>  [
                    'penjualan' => $sumTotalPenjualan,
                    'servis' => $sumTotalTransaksiServis,
                    'data_pendapatan' => $dataTransaksiPendapatan,
                    'total_pendapatan' => $totalPendapatan,
                ],
                'pembelian' => $sumTotalPembelian,
                'laba_rugi_koto' => $labaRugiKoto,
                'pengeluaran' => $dataTransaksiPengeluaran,
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ];
            return view('report::labaBersih.output', $data)->render();
        }

        $dari_tanggal = date('d/m/Y');
        $sampai_tanggal = date('d/m/Y');
        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];
        return view('report::labaBersih.index', $data);
    }

    public function print(Request $request)
    {
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');

        // penjualan
        $getPenjualan = new Penjualan();
        $dataPenjualan = $getPenjualan->dataTable();
        if ($dari_tanggal != '') {
            $dataPenjualan = $dataPenjualan->whereDate('created_at', '>=', $dari_tanggal);
        }
        if ($sampai_tanggal != '') {
            $dataPenjualan = $dataPenjualan->whereDate('updated_at', '<=', $sampai_tanggal);
        }
        $sumBayarPenjualan = $dataPenjualan->sum('bayar_penjualan');
        $sumKembalianPenjualan = $dataPenjualan->sum('kembalian_penjualan');
        $sumTotalPenjualan = $sumBayarPenjualan - $sumKembalianPenjualan;

        // transaksi servis
        $getTransaksiServis = new PenerimaanServis();
        $dataTransaksiServis = $getTransaksiServis->dataTable();
        if ($dari_tanggal != '') {
            $dataTransaksiServis->whereDate('created_at', '>=', $dari_tanggal);
        }
        if ($sampai_tanggal != '') {
            $dataTransaksiServis->whereDate('updated_at', '<=', $sampai_tanggal);
        }
        $dataTransaksiServis = $dataTransaksiServis
            ->whereIn('status_pservis', ['sudah diambil', 'komplain garansi']);

        $sumBayarServis = $dataTransaksiServis->sum('bayar_pservis');
        $sumKembalianServis = $dataTransaksiServis->sum('kembalian_pservis');
        $sumTotalTransaksiServis = $sumBayarServis - $sumKembalianServis;

        // biaya kategori pendapatan lainnya
        $transaksiPendapatan = TransaksiPendapatan::dataTable()->select('kategori_pendapatan_id', 'kategori_pendapatan.nama_kpendapatan', DB::raw('sum(jumlah_tpendapatan) as jumlah_tpendapatan'))
            ->join('kategori_pendapatan', 'transaksi_pendapatan.kategori_pendapatan_id', '=', 'kategori_pendapatan.id')
            ->groupBy('kategori_pendapatan_id', 'kategori_pendapatan.nama_kpendapatan');

        if ($dari_tanggal != '') {
            $transaksiPendapatan = $transaksiPendapatan->whereDate('tanggal_tpendapatan', '>=', $dari_tanggal);
        }
        if ($sampai_tanggal != '') {
            $transaksiPendapatan = $transaksiPendapatan->whereDate('tanggal_tpendapatan', '<=', $sampai_tanggal);
        }
        $dataTransaksiPendapatan = $transaksiPendapatan->get();
        $sumDataPendapatan = $dataTransaksiPendapatan->sum('jumlah_tpendapatan');
        $totalPendapatan = $sumTotalPenjualan + $sumTotalTransaksiServis + $sumDataPendapatan;
        // end biaya kategori pendapatan lainnya

        // pembelian
        $getPembelian = new Pembelian();
        $dataPembelian = $getPembelian->dataTable();
        if ($dari_tanggal != '') {
            $dataPembelian = $dataPembelian->whereDate('created_at', '>=', $dari_tanggal);
        }
        if ($sampai_tanggal != '') {
            $dataPembelian = $dataPembelian->whereDate('updated_at', '<=', $sampai_tanggal);
        }

        $sumBayarPembelian = $dataPembelian->sum('bayar_pembelian');
        $sumKembalianPembelian = $dataPembelian->sum('kembalian_pembelian');
        $sumTotalPembelian = $sumBayarPembelian - $sumKembalianPembelian;
        // end pembelian

        // laba / rugi koto
        $labaRugiKoto = $totalPendapatan - $sumTotalPembelian;
        // end laba / rugi koto

        // biaya kategori pendapatan lainnya
        $transaksiPengeluaran = TransaksiPengeluaran::dataTable()->select('kategori_pengeluaran_id', 'kategori_pengeluaran.nama_kpengeluaran', DB::raw('sum(jumlah_tpengeluaran) as jumlah_tpengeluaran'))
            ->join('kategori_pengeluaran', 'transaksi_pengeluaran.kategori_pengeluaran_id', '=', 'kategori_pengeluaran.id')
            ->groupBy('kategori_pengeluaran_id', 'kategori_pengeluaran.nama_kpengeluaran');

        if ($dari_tanggal != '') {
            $transaksiPengeluaran = $transaksiPengeluaran->whereDate('tanggal_tpengeluaran', '>=', $dari_tanggal);
        }
        if ($sampai_tanggal != '') {
            $transaksiPengeluaran = $transaksiPengeluaran->whereDate('tanggal_tpengeluaran', '<=', $sampai_tanggal);
        }
        $dataTransaksiPengeluaran = $transaksiPengeluaran->get();
        $sumDataPengeluaran = $dataTransaksiPengeluaran->sum('jumlah_tpengeluaran');
        $totalPengeluaran = $sumDataPengeluaran;
        // end biaya kategori pengeluaran lainnya

        // laba bersih
        $labaBersih = $labaRugiKoto - $totalPengeluaran;
        // end laba bersih

        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
            'pendapatan' =>  [
                'penjualan' => $sumTotalPenjualan,
                'servis' => $sumTotalTransaksiServis,
                'data_pendapatan' => $dataTransaksiPendapatan,
                'total_pendapatan' => $totalPendapatan,
            ],
            'pembelian' => $sumTotalPembelian,
            'laba_rugi_koto' => $labaRugiKoto,
            'pengeluaran' => $dataTransaksiPengeluaran,
            'total_pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        return view('report::labaBersih.print', $data);
    }
}
