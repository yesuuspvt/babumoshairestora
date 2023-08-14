<?php
namespace App\Controllers\super_admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\super_admin\RestaurantModel;
class User extends BaseController 
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
    public function userList()
    {
        $UserModel = model(UserModel::class);
        $session = session();
        $data = $UserModel->where(['is_active'=>1])->findAll();
        $data['user_list'] = $data;
        return view('super_admin/users/user_List', $data);
    }
    public function userManagement($id='')
    {
        $RestaurantModel = model(RestaurantModel::class);
        $UserModel = model(UserModel::class);
        $session = session();
        if($this->request->getMethod() === 'post' && $this->validate([
            // 'restaurant_id' => 'required',
            'full_name' => 'required',
            'address'  => 'required',
            'mobile'  => 'required|min_length[10]|regex_match[/^[0-9]{10}$/]',
            // 'email'    => 'required|valid_email',
            'gender'    => 'required',
            'shift'    => 'required',
            'username' => 'required',
            'role'=>'required',
            'password' => 'required'
        ]))
        {
            // $restaurant_id = $this->request->getPost('restaurant_id');
            $full_name = $this->request->getPost('full_name');
            $address = $this->request->getPost('address');
            $mobile = $this->request->getPost('mobile');
            // $email = $this->request->getPost('email');
            $gender = $this->request->getPost('gender');
            $username = $this->request->getPost('username');
            $role = $this->request->getPost('role');
            $shift = $this->request->getPost('shift');
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $id = $this->request->getPost('id');
            $data = array();
            if($id>0)
            {
                $data = [
                    // 'restaurant_id' => $restaurant_id,
                    'full_name' => $full_name,
                    'address'    => $address,
                    'mobile'    => $mobile,
                    // 'email'    => $email,
                    'role'    => $role,
                    'shift'    => $shift,
                    'gender'    => $gender,
                    'username' => $username,
                    'modified_at'    => date('Y-m-d H:i:s'),
                ];
                // print_r($data);exit;
            }
            else{
                $data = [
                    // 'restaurant_id' => $restaurant_id,
                    'full_name' => $full_name,
                    'address'    => $address,
                    'mobile'    => $mobile,
                    // 'email'    => $email,
                    'role'    => $role,
                    'shift'    => $shift,
                    'gender'    => $gender,
                    'username' => $username,
                    'password' => $password,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'modified_at'    => date('Y-m-d H:i:s'),
                ];
                // print_r($data);exit;
                
            }
            
            if($id>0)
            {
                if($UserModel->update($id, $data))
                {
                    $session->setFlashdata('success', 'Record updated successfully');
                    return redirect()->to('super-admin-user-list');
                }
                else{
                    $session->setFlashdata('error', 'data not inserted, please try later.');
                }
            }
            else{
                if($UserModel->insert($data))
                {
                    $session->setFlashdata('success', 'Record inserted successfully');
                    return redirect()->to('super-admin-user-list');
                }
                else{
                    $session->setFlashdata('error', 'data not inserted, please try later.');
                }
            }
        }
        $data = [];
        if($id > 0)
        {
            $user_data = $UserModel->where('id', $id)->first();
            // echo '<pre>';
            // print_r($user_data);
            // exit;
            $data['user_list'] = $user_data;
            $data['id'] = $id;
        }
        $restaurantKeyValueData = array();
        $Restaurants = $RestaurantModel->where(['status'=>1])->findAll();
        if(!empty($Restaurants))
        {
            foreach($Restaurants as $restautant)
            {
                $restaurantKeyValueData[$restautant['id']] = $restautant['name'];
            }
        }
        $data['restaurantKeyValueData'] = $restaurantKeyValueData;
        return view('super_admin/users/user_management', $data);
    }
    public function deleteUser($id='')
    {
        $UserModel = model(UserModel::class);
        $session = session();
        if($id>0)
        {
            $data = array();
            $data['is_active'] = 0;
            if($UserModel->update($id, $data))
            {
                $session->setFlashdata('success', 'Record deleted successfully');
                return redirect()->to('super-admin-user-list');
            }
            else{
                $session->setFlashdata('error', 'Record not deleted, try after sometime');
                return redirect()->to('super-admin-user-list');
            }
        }
    }
    public function updateStatus()
    {
        $UserModel = model(UserModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0);
        if ($this->request->isAJAX()) {
            //$id = service('request')->getPost('id');
            $id =  service('request')->getPost('id');
            //echo $id; exit;
            $status =  service('request')->getPost('status'); //$this->request->getPost('status');
            //echo $status; exit;
            $data = array();
            $data['is_active'] = $status;
            if($id > 0 && $UserModel->update($id, $data))
            {
                $res['SUCCESS'] = 1;
                $res['ERROR'] = 0;
            }
            else{
                $res['SUCCESS'] = 0;
                $res['ERROR'] = 1;
            }
            echo json_encode($res); exit;
            //return json_encode(['success'=> 'success', 'csrf' => csrf_hash(), 'query ' => $id ]);
        }
    }
}