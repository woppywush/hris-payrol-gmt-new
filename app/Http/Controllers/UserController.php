<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterUser;
Use Hash;
use Auth;
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


    public function delete($id)
    {
      $get = MasterUser::find($id);

      $get->delete();

      return redirect()->route('useraccount.create')->with('message', 'Berhasil menghapus akun.');
    }

    public function kelolaprofile()
    {
      $get = MasterUser::find(Auth::id());

      return view('pages.user.ubah')->with('getuser', $get);
    }

    public function updateprofile(Request $request)
    {
      $file = $request->file('url_foto');
      if ($file!="") {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();
        Image::make($file)->fit(160,160)->save('images/'. $photo_name);

        $setfoto = MasterUser::where('id', $request->id)->first();
        $setfoto->url_foto = $photo_name;
        $setfoto->nama = $request->name;
        $setfoto->update();
      } else {
        $set = MasterUser::find($request->id);
        $set->nama = $request->name;
        $set->update();
      }

      return redirect()->route('useraccount.profile')->with('message', 'Berhasil mengubah profile.');
    }

    public function updatepassword(Request $request)
    {
      $get = MasterUser::find($request->id);

      if(Hash::check($request->oldpassword, $get->password)) {
        $messages = [
          'oldpassword.required' => 'Password lama harus diisi.',
          'password.required' => 'Password baru harus diisi.',
          'password_confirmation.required' => 'Konfirmasi password baru harus diisi.',
          'password.confirmed' => 'Konfirmasi password tidak valid.',
        ];

        $validator = Validator::make($request->all(), [
          'oldpassword' => 'required',
          'password' => 'required|confirmed',
          'password_confirmation' => 'required'
        ], $messages);

        if ($validator->fails()) {
          return redirect()->route('useraccount.profile')
          ->withErrors($validator)
          ->with('messagefail', 'Terjadi kesalahan dalam perubahan password.')
          ->withInput();
        }

        $get->password = Hash::make($request->password);
        $get->save();

        return redirect()->route('useraccount.profile')
        ->with('message', 'Berhasil melakukan perubahan password.');
      } else {
        return redirect()->route('useraccount.profile')
          ->with('messagefail', 'Password lama tidak valid.');
      }
    }


}
