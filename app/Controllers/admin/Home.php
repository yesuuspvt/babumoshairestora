<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\admin\OrderModel;
use App\Models\super_admin\ProductModel;
class Home extends BaseController 
{
    public function __construct()
    {
        helper('form');
        $this->checkIsLoggedIn();
    }
    public function checkIsLoggedIn()
    {
        $session = session();
        $isLoggedIn = $session->get('isLoggedIn');
        if(!isset($isLoggedIn))
        {
            header('Location: '.site_url().'/super-admin-login');
            exit(); 
        }
    }
    public function dashboard()
    {
        // $data['total_menu'] = $this->UserModel->get_all('',array('is_available' => 1));
        $ProductModel = model(ProductModel::class);
        $OrderModel = model(OrderModel::class);
        $data['products'] = $ProductModel->where(['is_available'=> 1])->find();
        $date = date("Y-m-d");
        // echo $data; exit();
        $data['order'] = $OrderModel->where(["DATE_FORMAT(created_at, '%Y-%m-%d')" => $date])->find();
        return view('admin/Home/dashboard',$data);
    }
    public function logout()
    {
        unset(
            $_SESSION['isLoggedIn'],
            $_SESSION['username'],
            $_SESSION['id'],
            $_SESSION['is_active']
        );
        return redirect()->to('/super-admin-login');
    }
}