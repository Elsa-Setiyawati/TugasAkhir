<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('pelanggan')->get();
        return view('page.pelanggan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = DB::table('pelanggan')->updateOrInsert(
            [
                'pelanggan_id' => $request->pelanggan_id
            ],
            $request->except('_token', 'pelanggan_id')
        );
        if ($data) {
            return redirect(route('pelanggan.index'));
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('pelanggan')->where('pelanggan_id', $id)->delete();
        return redirect(route('pelanggan.index'));
    }
}
