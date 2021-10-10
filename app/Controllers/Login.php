<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('users/login');
    }

    public function process()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $dataUser = $this->usersModel->getUser($username);
        
            if (password_verify($password, $dataUser['PASSWORD'])) {
                session()->set([
                    'ID_USER' => $dataUser['ID_USER'],
                    'USERNAME' => $dataUser['USERNAME'],
                    'logged_in' => TRUE
                ]);
                return redirect()->to(base_url('dashboard'));
            } else {
                session()->setFlashdata('error', 'Username / Password Salah');
                return redirect()->back();
            }
    }

    function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}