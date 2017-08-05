<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use Validator;

use Auth;
use App\Models\MasterUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
  	 * Handle a login request to the application.
  	 *
  	 * @param  App\Http\Requests\LoginRequest  $request
  	 * @param  Guard  $auth
  	 * @return Response
  	 */
  	public function postLogin(Request $request, Guard $auth)
  	{
      $message = [
        'username.required' => 'Fill This Field',
        'password.required' => 'Fill This Field'
      ];

      $validator = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required',
      ], $message);

      if($validator->fails()) {
        return redirect()->route('index')->withErrors($validator)->withInput();
      }

      if(Auth::attempt(['username' => $request->username, 'password' => $request->password]))
      {
        $user = Auth::User();
        $set = MasterUser::find(Auth::user()->id);
        $getCounter = $set->login_count;
        $set->login_count = $getCounter+1;
        $set->save();

        session()->put('level', Auth::user()->level);

        return redirect()->route('dashboard');
      }
      else
      {
        return redirect()->route('index')->with('failedLogin', 'Periksa Kembali Email atau Password Anda.')->withInput();
      }

  	}

    public function getLogout()
    {
      session()->flush();
      Auth::logout();
      return redirect()->route('index');
    }
}
