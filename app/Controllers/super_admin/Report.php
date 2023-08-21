<?php
namespace App\Controllers\super_admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\super_admin\RestaurantModel;
use App\Models\super_admin\ProductModel;
use App\Models\super_admin\ProductimageModel;
use App\Models\super_admin\CategoryModel;
use App\Models\admin\OrderModel;
use App\Models\admin\OrderitemModel;
class Report extends BaseController 
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
    public function dailyReport($report='')
    {
        // echo $report; exit;
        // $ProductModel = model(ProductModel::class);
        // $ProductimageModel = model(ProductimageModel::class);
        $OrderModel = model(OrderModel::class);
        // $OrderitemModel = model(OrderitemModel::class);
        // $ProductimageModel = model(ProductimageModel::class);
        // $CategoryModel = model(CategoryModel::class);
        // $session = session();
        $todaydate    =date('Y-m-d');
        echo date('Y-m-d', strtotime($todaydate. ' - 30 days'));exit;
        

        switch ($report) {
            case 'Daily':
                $OrderModelLists = $OrderModel
                ->where('is_order_final', 0)
                ->where('DATE(created_at)', $todaydate)
                ->orderBy('id','DESC')->findAll();
                break;
            case 'Monthly':
                $OrderModelLists = $OrderModel
                ->where('is_order_final', 0)
                ->where('DATE(created_at)>=', date('Y-m-d', strtotime($todaydate. ' - 30 days')))
                ->orderBy('id','DESC')->findAll();
                break;
            case 'Yearly':
                $OrderModelLists = $OrderModel
                ->where('is_order_final', 0)
                ->where('DATE(created_at)>=', date('Y-m-d', strtotime($todaydate. ' - 365 days')))
                ->orderBy('id','DESC')->findAll();
                break;
            case 'cash':
                $OrderModelLists = $OrderModel
                ->where('is_order_final', 0)
                ->where('payment_type','cash')
                ->where('DATE(created_at)', $todaydate)
                ->orderBy('id','DESC')->findAll();
                break;
            case 'Digital':
                $OrderModelLists = $OrderModel
                ->where('is_order_final', 0)
                ->where('payment_type', 'digital')
                ->where('DATE(created_at)', $todaydate)
                ->orderBy('id','DESC')->findAll();
                break;
            case 'Summery':
                $OrderModelLists = $OrderModel
                // ->where('is_order_final', 0)
                ->where('DATE(created_at)', $todaydate)
                ->orderBy('id','DESC')->findAll();
                break;
                
            default:
                $OrderModelLists = $OrderModel
                ->orderBy('id','DESC')->findAll();
                break;
        }
       
        $data = [];
        $data['order_list'] = $OrderModelLists;
        return view('super_admin/report/dailyreport', $data);
    }
}