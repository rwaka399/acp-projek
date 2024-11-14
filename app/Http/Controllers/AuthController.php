<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.custom')->except(['loginPage', 'login']);
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $validate = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);
        if ($validate->fails()) {

            return ResponseFormatter::error(
                data: [
                    'message' => 'unauthorized',
                    'error' => $validate->errors()->all(),
                ],
                message: 'authentication failed',
                code: 403,
            );
        }

        $data = AuthService::login($credentials);

        if (!$data['status']) {
            return ResponseFormatter::error([
                'message' => "Unauthorized",
                'error'   => $data['errors'],
            ], 'Authentication Failed');
        }

        Session::put('token', $data['data']['token']);

        return redirect()->route('dashboard');
    }

    public function logout()
    {

        Session::flush('token');
        AuthService::logout();
       
        return redirect()->route('loginpage');
    }
}
