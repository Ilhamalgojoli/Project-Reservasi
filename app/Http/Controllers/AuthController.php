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

    # Controller login
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
                'profilephoto' => $service['profile']['photo'] ?? null,
                'faculty' => $service['profile']['facultyid'] ?? null,
                'faculty_name' => $service['profile']['faculty'] ?? null,
                'studyProgram' => $service['profile']['studyprogramid'] ?? null,
                'studyProgram_name' => $service['profile']['studyprogram'] ?? null,
                'phone_number' => $service['profile']['phone'] ?? null,
            ]);

            $roles = session('roles', []);
            
            if(is_array($roles) && count($roles) === 1) {
                return redirect()->route('index');
            }

            return redirect()->route('role-option');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['signIn' => 'Terjadi kesalahan saat memproses login.'])
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        session()->forget('roles');
        session()->forget('token');
        session()->forget('username');
        session()->forget('user_identifier');
        session()->forget('profilephoto');
        session()->forget('faculty');
        session()->forget('studyProgram');

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
