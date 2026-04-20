<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\App;

class SignInSignOutService
{
    private $get_role;

    public function __construct()
    {
        $this->get_role = env('URL_OPTION_ROLE');
    }

    public function login(array $data)
    {
        try {
            return $this->loginSso($data);
        } catch (\Exception $e) {
            return $this->loginLocal($data);
        }
    }

    # Login SSO yang nanti dipakai diproduction
    public function loginSso(array $data)
    {
        $url = env('URL_SSO');
        $get_profile = env('URL_PROFILE');

        $response = Http::asForm()->post($url, [
            'username' => $data['username'],
            'password' => $data['password'],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['token'] ?? null;

            if ($token) {
                $response_profile = Http::withToken($token)->get($get_profile);
                $profile = $response_profile->json();

                $response_role = Http::withToken($token)->get($this->get_role);
                $role = $response_role->json();

                return [
                    'data_role' => $role,
                    'token' => $token,
                    'profile' => $profile
                ];
            }
        } else {
            throw new \Exception('Username atau password tidak valid.');
        }
    }

    public function loginLocal(array $data)
    {
        if (App::environment('local')) {
            $username = $data['username'];
            $password = $data['password'];

            $user = User::where('username', $username)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                throw new \Exception('Username atau password tidak valid.');
            }
            
            $data_role = Role::select('id_role as id', 'role')
                ->get()
                ->toArray();

            return [
                'data_role' => $data_role,
                'token' => rand(10000000, 99999999),
            ];
        }
    }
}
