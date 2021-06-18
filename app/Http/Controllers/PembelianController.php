<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('pembelian')
        ->join('pemasok', 'pemasok_id', 'beli_pemasok_id')
        ->join('users', 'id', 'beli_user_id')
        ->get();
        return view('page.pembelian.index', compact('data'));
    }

    public function transaksi($id=null, $action=null)
    {
        $data = new \stdClass();
        $data->date = Carbon::now()->format("Y-m-d");
        $data->detail_pembelian = DB::table('detail_pembelian')->join('barang', 'barang_id', 'dbeli_barang_id')->whereNull('dbeli_beli_id')->get();
        $data->pemasok = DB::table('pemasok')->get();
        $data->barang = DB::table('barang')->get();
        $data->users = DB::table('users')->get();
        $data->id = $id;
        $data->action = $action;
        if($id){
            $data->beli =  DB::table('pembelian')->where('beli_id', $id)->first();
            $data->detail_pembelian = DB::table('detail_pembelian')->join('barang', 'barang_id', 'dbeli_barang_id')->where('dbeli_beli_id', $id)->get();
            $data->retur_pembelian = DB::table('retur_pembelian')->join('barang', 'barang_id', 'rb_barang_id')->where('rb_beli_id', $id)->get();
        }
        // ->join('pemasok', 'pemasok_id', 'beli_pemasok_id')
        // ->join('users', 'id', 'beli_user_id')
        // ->get();
        return view('page.pembelian.transaksi', compact('data'));
    }

    public function store(Request $request)
    {
        $data = DB::table('detail_pembelian')->updateOrInsert(
            [
                'dbeli_id' => $request->dbeli_id
            ],
            $request->except('_token', 'dbeli_id')
        );
        if ($data) {
            return redirect(route('pembelian.transaksi'));
        }
        return redirect()->back();
    }

    public function save_transaksi(Request $request)
    {
        // return $request->all();
        $id = DB::table('pembelian')->insertGetId(
            $request->except('_token')
        );
        $detail_pembelian = DB::table('detail_pembelian')->join('barang', 'barang_id', 'dbeli_barang_id')->whereNull('dbeli_beli_id')->get();
        foreach($detail_pembelian as $detail){
            $save_barang = DB::table('barang')->where('barang_id', $detail->dbeli_barang_id)->update(['barang_stok' => $detail->barang_stok+$detail->dbeli_jml, 'barang_hargabeli' => $detail->dbeli_harga]);
            $save_kartu = DB::table('kartupersediaan')->insert([
                'kp_tgl' => $request->beli_tgl,
                'kp_barang_id' => $detail->barang_id,
                'kp_jenis' => 'masuk',
                'kp_qty' =>  $detail->dbeli_jml,
                'kp_harga' =>  $detail->dbeli_harga
                ]);
                Helper::harga_terbaru($detail->dbeli_barang_id);
        }
        $save_barang_beli = DB::table('detail_pembelian')->whereNull('dbeli_beli_id')->update(['dbeli_beli_id' => $id]);
        if ($id) {
            return redirect(route('pembelian.index'));
        }
        return redirect()->back();
    }
    public function return_store(Request $request)
    {
        // return $request->all();
        $id = DB::table('retur_pembelian')->insertGetId(
            $request->except('_token', 'rb_id')
        );
        $nominal_retur = 0;
        $retur_pembelian = DB::table('retur_pembelian')->join('barang', 'barang_id', 'rb_barang_id')->where('rb_beli_id', $request->rb_beli_id)->get();
        $returbarang = DB::table('retur_pembelian')->join('barang', 'barang_id', 'rb_barang_id')->where('rb_id', $id)->first();
        $save_barang = DB::table('barang')->where('barang_id', $returbarang->rb_barang_id)->update(['barang_stok' => $returbarang->barang_stok-$returbarang->rb_jml]);
            $save_kartu = DB::table('kartupersediaan')->insert([
                'kp_tgl' => $request->rb_tgl,
                'kp_barang_id' => $returbarang->barang_id,
                'kp_jenis' => 'keluar',
                'kp_qty' =>  $returbarang->rb_jml,
                'kp_harga' =>  $returbarang->rb_harga
                ]);
        foreach($retur_pembelian as $detail){
            $nominal_retur = $nominal_retur + ($detail->rb_jml*$detail->rb_harga);
        }
        $save_barang_beli = DB::table('pembelian')->where('beli_id', $request->rb_beli_id)->update(['beli_tot_retur_beli' => $nominal_retur]);
        Helper::harga_terbaru($returbarang->rb_barang_id);
        if ($id) {
            return redirect(route('pembelian.index'));
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('detail_pembelian')->where('dbeli_id', $id)->delete();
        return redirect(route('pembelian.transaksi'));
    }
}
