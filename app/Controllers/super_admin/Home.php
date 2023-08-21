<?php
namespace App\Controllers\super_admin;
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
        $data['cash_payment'] = 10;
        $data['current_running_order'] = 3;
        $data['total_order_payment'] = 7;
        $data['total_digital_payment'] = 5;
        $data['client_login'] = 9;
        $data['hourly_avg_order'] = 12;
        return view('super_admin/Home/dashboard',$data);
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