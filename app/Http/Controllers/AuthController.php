<?php

namespace App\Http\Controllers;

use App;
use App\Services\SignInSignOutService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected SignInSignOutService $service)
    {
    }

    public function index()
    {
        return view('authentication.signin');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [

        ]);

        try {
            $service = $this->service->login($validate);

            session([
                'roles' => $service['data_role'],
                'token' => $service['token'],
                'username' => $service['profile']['fullname'] ?? 'Admin',
                'user_identifier' => $service['profile']['numberid'] ?? rand(10000000, 99999999),
                'profilephoto' => $service['profile']['photo'] ?? null
            ]);

            return redirect()->route('role-option');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['signIn' => $e->getMessage()])
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
