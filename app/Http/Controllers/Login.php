<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = strtoupper(md5($request->password));
        $where = array(
            'email' => $email,
            'status_activate' => 'Y'
        );
        $data = DB::connection('ifca1')->table('mgr.sysuser')->where($where)->get();
        foreach ($data as $dt) {
            $pwd = $dt->password;
            $usernm = $dt->name;
            $profil = $dt->pict;
        }

        if (count($data) > 0) {
            $emailpassword = strtoupper(md5(strtoupper(md5($email)) . 'P@ssw0rd' . $password));
            if ($emailpassword === $pwd) {
                Session::put('name', $usernm);
                Session::put('email', $email);
                Session::put('profil_pict', $profil);
                Session::put('is_login', TRUE);

                return redirect('/webadmin/dash');
            } else {
                return redirect('/webadmin')->with('alert', 'Wrong Password!');
            }
        } else {
            return redirect('/webadmin')->with('alert', 'User is not valid!');
        }
    }

    public function dashboard()
    {
        if (!Session::get('is_login')) {
            return redirect('/webadmin')->with('alert', 'Please login first!');
        }
        return view('dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/webadmin')->with('alert', 'Already logout!');
    }
}
