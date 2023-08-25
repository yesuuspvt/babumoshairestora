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
        $OrderModel = model(OrderModel::class);
        $data = [];
        $todaydate    =date('Y-m-d');
        if($this->request->getMethod() === 'post'){
            $reportType = $this->request->getPost('report');
            $startdate = $this->request->getPost('startdate');
            $enddate = $this->request->getPost('enddate');
            // print_r($this->request->getPost());exit;
            switch ($reportType) {
                case 'Daily':
                    $OrderModelLists = $OrderModel
                    ->where('is_order_final', 1)
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate)
                    ->orderBy('id','DESC')->findAll();
                    break;
                case 'Monthly':
                    $OrderModelLists = $OrderModel
                    ->where('is_order_final', 1)
                    ->where('DATE(created_at)>=', date('Y-m-d', strtotime($todaydate. ' - 30 days')))
                    ->orderBy('id','DESC')->findAll();
                    break;
                case 'Yearly':
                    $OrderModelLists = $OrderModel
                    ->where('is_order_final', 1)
                    ->where('DATE(created_at)>=', date('Y-m-d', strtotime($todaydate. ' - 365 days')))
                    ->orderBy('id','DESC')->findAll();
                    break;
                case 'Cash':
                    $OrderModelLists = $OrderModel
                    ->where('is_order_final', 1)
                    ->where('payment_type','cash')
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate)
                    ->orderBy('id','DESC')->findAll();
                    break;
                case 'Digital':
                    $OrderModelLists = $OrderModel
                    ->where('is_order_final', 1)
                    ->where('payment_type', 'digital')
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate)
                    ->orderBy('id','DESC')->findAll();
                    break;
                case 'Summery':
                    $OrderModelLists = $OrderModel
                    ->where('is_order_final', 1)
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate)
                    ->orderBy('id','DESC')->findAll();
                    break;
                    
                default:
                    $OrderModelLists = $OrderModel
                    ->orderBy('id','DESC')->findAll();
                    break;
            }
        }
        $OrderModelLists=[];
       
        $data['title'] = $report;
        $data['order_list'] = $OrderModelLists;
        return view('super_admin/report/dailyreport', $data);
    }
    public function get_items()
    {
        $search = $_GET['search'];
        $offset = $_GET['start'];
        $limit = $_GET['length'];
        $order = $_GET['order'];
        $reportType = $_GET['report'];
        $column = array('parameter', 'method', 'type');
        $orderColumn = isset($order[0]['column']) ? $column[$order[0]['column']] : 'parameter';
        $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
        $ordrBy = $orderColumn . " " . $orderDirection;
        $OrderModel = model(OrderModel::class);
        if(!empty($search['value']) && $search['value'] !="")
        {
            $OrderModel->like('order_id', $search['value']);
        }
        if(!empty($reportType) && $reportType!=''){
            $startdate = $_GET['startdate'];
            $enddate = $_GET['enddate'];
            $month = $_GET['month'];
            $year = $_GET['year'];
            $OrderModel->where('is_order_final', 1);
            switch ($reportType) {
                case 'Daily':
                    $OrderModel
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate);
                    break;
                case 'Monthly':
                    $OrderModel
                    ->where('MONTH(created_at)',$month)
                    ->where('YEAR(created_at)',$year );
                    break;
                case 'Yearly':
                    $OrderModel
                    ->where('YEAR(created_at)',$year);
                    break;
                case 'Cash':
                    $OrderModel
                    ->where('payment_type','cash')
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate);
                    break;
                case 'Digital':
                    $OrderModel
                    ->where('payment_type', 'digital')
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate);
                    break;
                case 'Summery':
                    $OrderModel
                    ->where('DATE(created_at)>=', $startdate)
                    ->where('DATE(created_at)<=', $enddate);
                    break;
                    
                default:
                    
                    break;
            }
        }
        // if(!empty($from_date))
        // {
        //     $OrderModel->where('date', $from_date);
        // }
        // $OrderModel->orderBy($orderColumn, $orderDirection);
        $OrderModel->orderBy('id', $orderDirection);
        $OrderModel->limit($limit, $offset);
        $result = $OrderModel->get();


        //Total row count
        if(!empty($search))
        {
            $OrderModel->like('order_id', $search['value']);
        }

        if(!empty($from_date))
        {
            $OrderModel->where('date', $from_date);
        }
        $OrderModel->orderBy('id', $orderDirection);
        $count = $OrderModel->countAllResults();

        $data = array();
        if (!empty($result->getResult())) {
            foreach ($result->getResult() as $k => $v) {
                $data[] = array(
                    'id'=>$v->id,
                    'order_id' => $v->order_id,
                    'user_id' => $v->user_id,
                    'invoice_no' => $v->invoice_no,
                    'order_amount' => $v->order_amount,
                    'discount_type' => $v->discount_type,
                    'discount_amount' => $v->discount_amount,
                    'gst_amount' => $v->gst_amount,
                    'total_amount' => $v->total_amount,
                    'total_amount_after_gst' => $v->total_amount_after_gst,
                    'payment_type' => $v->payment_type,
                    'order_type' => $v->order_type,
                    'table_no' => $v->table_no,
                );
            }
        }
        /**
         * draw,recordTotal,recordsFiltered is required for pagination and info.
         */
        $results = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => count($data),
            "recordsFiltered" => $count,
            "data" => $data 
        );

        echo json_encode($results);
        
        
    //    $draw = intval($_GET['draw']);
    //    $start = intval($_GET['start']);
    //    $length = intval($_GET['length']);
    //    $OrderModel = model(OrderModel::class);
        

    //    $query = $OrderModel->orderBy('id','DESC')->findAll();;
    //    print_r($query );exit;
 
    //    $listData = $OrderModel->get_all('', array('is_order_final ' => '1'), array(), '', '', array('id', 'DESC'));
    //    $data = array();
    //    foreach($query as $r) {
    //        //<a href='javascript:void(0)' class='delete-cylinder-type' data-id='".$r['id']."'><button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></a>
    //        $data[] = array(
    //            $r['id'],
    //            $r['order_id'],
    //        );
    //    }
    //    $output = array(
    //        "draw" => $draw,
    //        "recordsTotal" => $OrderModel->num_rows(),
    //        "recordsFiltered" =>  $OrderModels->num_rows(),
    //        "data" => $data
    //    );
    //    echo json_encode($output);
    //    exit(); 
 
    //    foreach($query->getResult() as $r) {
    //         $data[] = array(
    //              $r->id,
    //              $r->order_id,
    //              $r->order_amount
    //         );
    //    }
 
 
    //    $result = array(
    //             "draw" => $draw,
    //               "recordsTotal" =>100,
    //             //   "recordsTotal" => $query->getNumRows(),
    //             //   "recordsFiltered" =>  $query->getNumRows(),
    //               "recordsFiltered" =>  100,
    //               "data" => $data
    //          );
 
 
    //    echo json_encode($result);
    //    exit();
   }
   public function index()
   {
      return view('super_admin/report/daily');
   }
}