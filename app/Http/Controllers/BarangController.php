<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        $data = DB::table('barang')->updateOrInsert(
            [
                'barang_id' => $request->barang_id
            ],
            $request->except('_token', 'barang_id')
        );
        if ($data) {
            return redirect(route('barang.index'));
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('barang')->where('barang_id', $id)->delete();
        return redirect(route('barang.index'));
    }
}
