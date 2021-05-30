<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('pemasok')->get();
        return view('page.pemasok.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = DB::table('pemasok')->updateOrInsert(
            [
                'pemasok_id' => $request->pemasok_id
            ],
            $request->except('_token', 'pemasok_id')
        );
        if ($data) {
            return redirect(route('pemasok.index'));
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('pemasok')->where('pemasok_id', $id)->delete();
        return redirect(route('pemasok.index'));
    }
}
