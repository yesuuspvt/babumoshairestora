<?php
namespace App\Controllers\super_admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;

class Auth extends BaseController
{
    public function __constructor()
    {
        helper('form');
    }
    public function login()
    {
        //echo password_hash("123", PASSWORD_DEFAULT); exit; //creaded a password for admin panel
        return view('super_admin/auth/login');
    }
    public function authenticationcheck()
    {
        if($this->request->getMethod() === 'post' && $this->validate([
            'username' => 'required',
            'password'  => 'required',
        ]))
        {
            $session = session();
            $userModel = model(UserModel::class);
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $data = $userModel->where('username', $username)->first();
            if($data){
                $pass = $data['password'];
                $authenticatePassword = password_verify($password, $pass);
                if($authenticatePassword){
                    if($data['is_active'] == 1 && ($data['role'] == 'Super_Admin' || $data['role'] == 'User'))
                    {
                        $ses_data = [
                            'id' => $data['id'],
                            'name' => !empty($data['full_name'])?$data['full_name']:$data['role'],
                            'username' => $data['username'],
                            'is_active' => $data['is_active'],
                            'role' => $data['role'],
                            'restaurant_id' => 0,
                            // 'restaurant_id' => $data['restaurant_id'],
                            'isLoggedIn' => TRUE
                        ];
                        $session->set($ses_data);
                        if($data['role']=='Super_Admin'){
                            return redirect()->to('/super-admin-dashboard');
                        }elseif($data['role']=='User'){
                            return redirect()->to('/user-dashboard');
                        }
                    }
                    else{
                        $session->setFlashdata('error', 'Your activation status is false');
                        return redirect()->to('/super-admin-login');
                    }
                }else{
                    $session->setFlashdata('error', 'Password is incorrect.');
                    return redirect()->to('/super-admin-login');
                }
            }else{
                $session->setFlashdata('error', 'Username does not exist.');
                return redirect()->to('/super-admin-login');
            }
        }
    }
    public function dashboard()
    {
        return view('super_admin/Auth/dashboard');
    }
}
