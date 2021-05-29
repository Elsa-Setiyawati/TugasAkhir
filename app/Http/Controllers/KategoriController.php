<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('kategori')->get();
        return view('page.kategori.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = DB::table('kategori')->updateOrInsert(
            [
                'kategori_id' => $request->kategori_id
            ],
            $request->except('_token', 'kategori_id')
        );
        if ($data) {
            return redirect(route('kategori.index'));
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('kategori')->where('kategori_id', $id)->delete();
        return redirect(route('kategori.index'));
    }
}
