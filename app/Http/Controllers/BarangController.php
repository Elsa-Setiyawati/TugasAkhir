<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('barang')->join('kategori', 'kategori_id', 'barang_kategori_id')->get();
        $data->kategori = DB::table('kategori')->get();
        return view('page.barang.index', compact('data'));
    }

    public function store(Request $request)
    {
        if($request->barang_id==null) {
            $barang_id = DB::table('barang')->insertGetId(
                $request->except('_token', 'barang_id')
            );
            $save_kartu = DB::table('kartupersediaan')->insert([
                'kp_tgl'=>Carbon::now(),
                'kp_barang_id' => $barang_id,
                'kp_jenis' => 'Persediaan Awal',
                'kp_qty' =>  $request->barang_stok,
                'kp_harga' =>  $request->barang_hargapokok
            ]);
            if ($save_kartu) {
                return redirect(route('barang.index'));
            }

        }else{
            $data = DB::table('barang')->updateOrInsert(
                [
                    'barang_id' => $request->barang_id
                ],
                $request->except('_token', 'barang_id')
            );
            if ($data) {
                return redirect(route('barang.index'));
            }
        }
        
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('barang')->where('barang_id', $id)->delete();
        return redirect(route('barang.index'));
    }
}
