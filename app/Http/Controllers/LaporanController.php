<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pages.laporan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lap_pembelian_periode(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        //start variable buat ambil data pembiayaan, before get
        $detail_pembelian = DB::table('detail_pembelian')
        ->join('pembelian', 'beli_id', 'dbeli_beli_id')
        ->join('pemasok', 'pemasok_id', 'beli_pemasok_id')
        ->join('users', 'id', 'beli_user_id')
        ->join('barang', 'barang_id', 'dbeli_barang_id')
        ->whereBetween('beli_tgl', [$data->startdate, $data->enddate])
        ->orderby('beli_id', 'asc');
        $daftar_pembelian = $detail_pembelian->pluck('dbeli_id');
        $data->list = $detail_pembelian->get();

        //end variable buat ambil data pembiayaan, before get
       
        //start variable buat ambil data id pembiayaan

        //start variable buat ambil data angsuran berdasarakan data id pembiayaan
       // $data->angsuran = DB::table('angsuran')->wherein('angsuran_pembiayaan_id', $daftar_pembiayaan)->get();

        //start variable buat ambil data pembiayaan

    //    dd($data);
        return view('page.laporan.lap_pembelian_periode',  compact('data'));
    }

    public function lap_retur_pembelian_periode(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        //start variable buat ambil data pembiayaan, before get
        $retur_pembelian = DB::table('retur_pembelian')
        ->join('pembelian', 'beli_id', 'rb_beli_id')
        ->join('barang', 'barang_id', 'rb_barang_id')
        ->whereBetween('rb_tgl', [$data->startdate, $data->enddate])
        ->orderby('rb_id', 'asc');
        //end variable buat ambil data pembiayaan, before get

        //start variable buat ambil data id pembiayaan
        $daftar_retur_pembelian = $retur_pembelian->pluck('rb_id');

        //start variable buat ambil data angsuran berdasarakan data id pembiayaan
       // $data->angsuran = DB::table('angsuran')->wherein('angsuran_pembiayaan_id', $daftar_pembiayaan)->get();

        //start variable buat ambil data pembiayaan
        $data->list = $retur_pembelian->get();
    //    dd($data);
        return view('page.laporan.lap_retur_pembelian_periode',  compact('data'));
    }
    public function lap_penjualan_periode(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        //start variable buat ambil data pembiayaan, before get
        $detail_penjualan = DB::table('detail_penjualan')
        ->join('penjualan', 'jual_id', 'djual_jual_id')
        ->join('pelanggan', 'pelanggan_id', 'jual_pelanggan_id')
        ->join('users', 'id', 'jual_user_id')
        ->join('barang', 'barang_id', 'djual_barang_id')
        ->whereBetween('jual_tgl', [$data->startdate, $data->enddate])
        ->orderby('jual_id', 'asc');
        //end variable buat ambil data pembiayaan, before get

        //start variable buat ambil data id pembiayaan
        $daftar_penjualan = $detail_penjualan->pluck('djual_id');

        //start variable buat ambil data angsuran berdasarakan data id pembiayaan
       // $data->angsuran = DB::table('angsuran')->wherein('angsuran_pembiayaan_id', $daftar_pembiayaan)->get();

        //start variable buat ambil data pembiayaan
        $data->list = $detail_penjualan->get();
    //    dd($data);
        return view('page.laporan.lap_penjualan_periode',  compact('data'));
    }
    public function lap_retur_penjualan_periode(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        //start variable buat ambil data pembiayaan, before get
        $retur_penjualan = DB::table('retur_penjualan')
        ->join('penjualan', 'jual_id', 'rj_jual_id')
        ->join('barang', 'barang_id', 'rj_barang_id')
        ->whereBetween('rj_tgl', [$data->startdate, $data->enddate])
        ->orderby('rj_tgl', 'asc');
        //end variable buat ambil data pembiayaan, before get

        //start variable buat ambil data id pembiayaan
        $daftar_retur_penjualan = $retur_penjualan->pluck('rj_id');

        //start variable buat ambil data angsuran berdasarakan data id pembiayaan
       // $data->angsuran = DB::table('angsuran')->wherein('angsuran_pembiayaan_id', $daftar_pembiayaan)->get();

        //start variable buat ambil data pembiayaan
        $data->list = $retur_penjualan->get();
    //    dd($data);
        return view('page.laporan.lap_retur_penjualan_periode',  compact('data'));
    }
    public function lap_kartu_gudang(Request $request)
    {
        $data =  new \stdClass();
        $data->barang = DB::table('barang')->get();
        $data->barang_id = ($request->barang_id) ? $request->barang_id : $data->barang[0]->barang_id;
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->barangpilih = DB::table('barang')->where('barang_id', $data->barang_id)->first();
        $data->persediaan_awal = 0;
        $persediaan_awal = DB::table('kartupersediaan')
        ->where('kp_tgl', '<', $data->startdate)
        ->where('kp_barang_id', $data->barang_id)
        ->join('barang', 'barang_id', 'kp_barang_id')
        ->orderby('kp_tgl', 'asc')->get();
        foreach($persediaan_awal as $pa){
            if($pa->kp_jenis == 'Persediaan Awal' || $pa->kp_jenis == 'masuk'){
                $data->persediaan_awal = $data->persediaan_awal + $pa->kp_qty;
            }elseif ($pa->kp_jenis == 'keluar') {
                $data->persediaan_awal = $data->persediaan_awal - $pa->kp_qty;
            }
        }
        //start variable buat ambil data pembiayaan, before get
        $kartupersediaan = DB::table('kartupersediaan')
        ->join('barang', 'barang_id', 'kp_barang_id')
        ->where('kp_barang_id', $data->barang_id)
        ->whereBetween('kp_tgl', [$data->startdate, $data->enddate])
        ->orderby('kp_tgl', 'asc');


        //start variable buat ambil data pembiayaan
        $data->list = $kartupersediaan->get();
    //    dd($data);
        return view('page.laporan.kartu_gudang',  compact('data'));
    }

    public function lap_kartu_persediaan(Request $request)
    {
        $data =  new \stdClass();
        $data->barang = DB::table('barang')->get();
        $data->barang_id = ($request->barang_id) ? $request->barang_id : $data->barang[0]->barang_id;
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->barangpilih = DB::table('barang')->where('barang_id', $data->barang_id)->first();
        $data->persediaan_awal = 0;
        $persediaan_awal = DB::table('kartupersediaan')
        ->where('kp_tgl', '<', $data->startdate)
        ->where('kp_barang_id', $data->barang_id)
        ->join('barang', 'barang_id', 'kp_barang_id')
        ->orderby('kp_id', 'asc')->get();
        foreach($persediaan_awal as $pa){
            if($pa->kp_jenis == 'Persediaan Awal' || $pa->kp_jenis == 'masuk'){
                $data->persediaan_awal = $data->persediaan_awal + $pa->kp_qty;
            }elseif ($pa->kp_jenis == 'keluar') {
                $data->persediaan_awal = $data->persediaan_awal - $pa->kp_qty;
            }
        }
        //start variable buat ambil data pembiayaan, before get
        $kartupersediaan = DB::table('kartupersediaan')
        ->join('barang', 'barang_id', 'kp_barang_id')
        ->where('kp_barang_id', $data->barang_id)
        ->whereBetween('kp_tgl', [$data->startdate, $data->enddate])
        ->orderby('kp_id', 'asc');

        $data->awalan = Helper::persediaan_awal($data->barang_id, $data->startdate);


        //start variable buat ambil data pembiayaan
        $data->list = $kartupersediaan->get();
    //    dd($data);
        return view('page.laporan.kartu_persediaan',  compact('data'));
    }
}