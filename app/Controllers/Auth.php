<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->base_model = model('Users');
    }

    public function login()
    {
        if (session()->isLogin) return redirect()->to(base_url($this->user_role) . '/dashboard');
        $data['title'] = 'Login';

        $view['content'] = view('auth/login', $data);
        return view('dashboard/header', $view);
        
    }

    public function loginProcess()
    {
        $rules = [
            'id_user'   => 'required|alpha_numeric',
            'password'  => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $password = $this->request->getVar('password');
            $where = [
                'id'        => $this->request->getVar('id_user', $this->filter),
                'password'  => $this->base_model->password_hash($password),
            ];
            $user = $this->base_model->where($where)->first();

            $cek = $this->base_model->where($where)->countAllResults();
            if ($cek == 1) {
                $session = [
                    'isLogin'   => true,
                    'id_user'   => $user['id'],
                ];
                session()->set($session);
                $user_role = model('Role')->where('id', $user['id_role'])->first()['slug'];
                return redirect()->to(base_url($user_role) . '/dashboard');
            } else {
                return redirect()->to(base_url('login'))
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Email atau password salah!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
