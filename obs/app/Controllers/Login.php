<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\TeacherModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login_form');
    }

    public function auth()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => true,
            ]);

           
            if ($user['role'] == 'ogrenci') {
                $ogrenci = (new StudentModel())->where('user_id', $user['id'])->first();
                $session->set('name', $ogrenci['name']);
            } elseif ($user['role'] == 'ogretmen') {
                $ogretmen = (new TeacherModel())->where('user_id', $user['id'])->first();
                $session->set('name', $ogretmen['name']);
            } elseif ($user['role'] == 'mudur') {
                
                $session->set('name', $user['username']);
            }

            // yönlendirme
            if ($user['role'] == 'mudur') {
                return redirect()->to('/mudur/dashboard');
            } elseif ($user['role'] == 'ogretmen') {
                return redirect()->to('/ogretmen/dashboard');
            } else {
                return redirect()->to('/ogrenci/dashboard');
            }
            
        } else {
            return redirect()->to('/login')->with('error', 'Geçersiz kullanıcı adı veya şifre');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
