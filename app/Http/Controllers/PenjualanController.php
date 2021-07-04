<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('penjualan')
        ->join('pelanggan', 'pelanggan_id', 'jual_pelanggan_id')
        ->join('users', 'id', 'jual_user_id')
        ->get();
        return view('page.penjualan.index', compact('data'));
    }

    public function transaksi($id=null, $action=null)
    {
        $data = new \stdClass();
        $data->date = Carbon::now()->format("Y-m-d");
        $data->detail_penjualan = DB::table('detail_penjualan')->join('barang', 'barang_id', 'djual_barang_id')->whereNull('djual_jual_id')->get();
        $data->pelanggan = DB::table('pelanggan')->get();
        $data->barang = DB::table('barang')->get();
        $data->users = DB::table('users')->get();
        $data->id = $id;
        $data->action = $action;
        if($id){
            $data->jual =  DB::table('penjualan')->where('jual_id', $id)->first();
            $data->detail_penjualan = DB::table('detail_penjualan')->join('barang', 'barang_id', 'djual_barang_id')->where('djual_jual_id', $id)->get();
            $data->retur_penjualan = DB::table('retur_penjualan')->join('barang', 'barang_id', 'rj_barang_id')->where('rj_jual_id', $id)->get();
        }
        // ->join('pemasok', 'pemasok_id', 'beli_pemasok_id')
        // ->join('users', 'id', 'beli_user_id')
        // ->get();
        return view('page.penjualan.transaksi', compact('data'));
    }

    public function store(Request $request)
    {
        $data = DB::table('detail_penjualan')->updateOrInsert(
            [
                'djual_id' => $request->djual_id
            ],
            $request->except('_token', 'djual_id')
        );
        if ($data) {
            return redirect(route('penjualan.transaksi'));
        }
        return redirect()->back();
    }

    public function save_transaksi(Request $request)
    {
        // return $request->all();
        $id = DB::table('penjualan')->insertGetId(
            $request->except('_token')
        );
        $detail_penjualan = DB::table('detail_penjualan')->join('barang', 'barang_id', 'djual_barang_id')->whereNull('djual_jual_id')->get();
        foreach($detail_penjualan as $detail){
            $save_barang = DB::table('barang')->where('barang_id', $detail->djual_barang_id)->update(['barang_stok' => $detail->barang_stok-$detail->djual_jml]);
            $save_kartu = DB::table('kartupersediaan')->insert([
                'kp_tgl' => $request->jual_tgl,
                'kp_barang_id' => $detail->barang_id,
                'kp_jenis' => 'Penjualan',
                'kp_ket' => 'Penjualan',
                'kp_qty' =>  -($detail->djual_jml),
                'kp_harga' =>  $detail->djual_hargapokok,
                'kp_total' =>  -($detail->djual_jml*$detail->djual_hargapokok)
                ]);
        }
        $save_barang_jual = DB::table('detail_penjualan')->whereNull('djual_jual_id')->update(['djual_jual_id' => $id]);
        if ($id) {
            return redirect(route('penjualan.index'));
        }
        return redirect()->back();
    }
    public function return_store(Request $request)
    {
        // return $request->all();
        $id = DB::table('retur_penjualan')->insertGetId(
            $request->except('_token', 'rj_id', 'rj_hargapokok')
        );
        $nominal_retur = 0;
        $retur_penjualan = DB::table('retur_penjualan')->join('barang', 'barang_id', 'rj_barang_id')->where('rj_jual_id', $request->rj_jual_id)->get();
        $returbarang = DB::table('retur_penjualan')->join('barang', 'barang_id', 'rj_barang_id')->where('rj_id', $id)->first();
        $save_barang = DB::table('barang')->where('barang_id', $returbarang->rj_barang_id)->update(['barang_stok' => $returbarang->barang_stok+$returbarang->rj_jml]);
            $save_kartu = DB::table('kartupersediaan')->insert([
                'kp_tgl' => $request->rj_tgl,
                'kp_barang_id' => $returbarang->barang_id,
                'kp_jenis' => 'Penjualan',
                'kp_ket' => 'Retur Penjualan',
                'kp_qty' =>  $returbarang->rj_jml,
                'kp_harga' =>  $request->rj_hargapokok,
                'kp_total' =>  $returbarang->rj_jml*$request->rj_hargapokok
                ]);
                Helper::harga_terbaru($returbarang->barang_id);
        foreach($retur_penjualan as $detail){
            $nominal_retur = $nominal_retur + ($detail->rj_jml*$detail->rj_harga);
        }
        $save_barang_jual = DB::table('penjualan')->where('jual_id', $request->rj_jual_id)->update(['jual_tot_retur_jual' => $nominal_retur]);
        if ($id) {
            return redirect('/penjualan/transaksi/'.$request->rj_jual_id.'/retur');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('detail_penjualan')->where('djual_id', $id)->delete();
        return redirect(route('penjualan.transaksi'));
    }
}
