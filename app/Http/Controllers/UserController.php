<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterUser;
Use Hash;
use DB;
use Image;
use Validator;

class UserController extends Controller
{
    /**
    * Authentication controller.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index()
    {
      $getuser = MasterUser::all();

      return view('pages.user.index', compact('getuser'));
    }

    public function store(Request $request)
    {
      $messages = [
        'email.required' => 'Anda harus mengisi email',
        'username.required' => 'Username harus diisi',
        'username.unique' => 'Username sudah dipakai',
        'password.required' => 'Password harus diisi',
        'password.confirmed' => 'Konfirmasi password tidak valid',
        'level.required' => 'Anda harus memilih Level Akses',
        'nama.required' => 'Anda harus mengisi nama',
        'password_confirmation.required' => 'Konfirmasi password harus diisi',
      ];

      $validator = Validator::make($request->all(), [
            'username' => 'required|unique:master_users',
            'password' => 'required|confirmed',
            'email' => 'required',
            'level' => 'required',
            'nama' => 'required',
            'password_confirmation' => 'required',
        ], $messages);

      if ($validator->fails()) {
        return redirect()->route('useraccount.index')->withErrors($validator)->withInput();
      }

      $user = new MasterUser;
      $user->nama = $request->nama;
      $user->username = $request->username;
      $user->password = Hash::make($request->password);
      $user->email = $request->email;
      $user->login_count = 1;
      $user->level = $request->level;
      $user->url_foto = 'user-not-found.png';
      $user->save();

      return redirect()->route('useraccount.index')->with('message', 'Berhasil Menambahkan User');
    }
}
