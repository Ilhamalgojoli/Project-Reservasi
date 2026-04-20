<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleOption extends Controller
{
    public function index()
    {
        return view('authentication.role-option');
    }

    public function choseRole(Request $request)
    {
        $validate = $request->validate([
            'role_id' => 'required',
            'role_name' => 'required|string'
        ]);

        session([
            'role_id' => $validate['role_id'],
            'role_name' => $validate['role_name']
        ]);

        return redirect()->route('index');
    }
}
