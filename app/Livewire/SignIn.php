<?php

namespace App\Livewire;

use Livewire\Component;

class SignIn extends Component
{
    public $username;
    public $password;

    protected function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string'
        ];
    }

    protected function messages()
    {
        return [
            'username.required' => 'Silakan masukkan username Anda.',
            'username.string' => 'Format username tidak valid.',

            'password.required' => 'Silakan masukkan password Anda.',
            'password.string' => 'Format password tidak valid.',
        ];
    }

    protected function service()
    {
        return new \App\Services\SignInSignOutService();
    }

    public function render()
    {
        return view('livewire.sign-in');
    }

    public function login()
    {
        try {
            $data = $this->validate();

            $this->service()->loginProcessed($data);

            return redirect()->route('role-option');
        } catch (\DomainException $e) {
            return redirect()->route('login');
        }
    }
}
