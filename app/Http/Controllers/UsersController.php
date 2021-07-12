<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use Auth;
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = new \stdClas();
        $data->list = DB::table('users')->get();
        return view('page.users.index', compact('data'));
    }
    public function edit($id)
    {
        $data = new \stdClass();
        $data->list = DB::table('users')->where('id',$id)->first();
        return view('page.users.edit', compact('data'));
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
            if (Auth::user()->hak_akses == 'Pemilik'){
            return redirect(route('users.index'));
        }
        return redirect(route('home'));
    }

    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect(route('users.index'));
    }
}
