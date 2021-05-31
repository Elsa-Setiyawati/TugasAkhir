<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClass();
        $data->list = DB::table('users')->get();
        return view('page.users.index', compact('data'));
    }

    public function store(Request $request)
    {
        $excep = ['_token', 'id'];
        if (empty($request['password'])) { 
            $excep = ['_token','id', 'password' ];
        }else{
            $request['password'] = bcrypt($request['password']);
        }
        $data = DB::table('users')->updateOrInsert(
            [
                'id' => $request->id
            ],
            $request->except($excep)
        );
        if ($data) {
            return redirect(route('users.index'));
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect(route('users.index'));
    }
}
