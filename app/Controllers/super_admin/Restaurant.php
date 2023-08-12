<?php
namespace App\Controllers\super_admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\super_admin\RestaurantModel;
class Restaurant extends BaseController 
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
    public function restaurantList()
    {
        $RestaurantModel = model(RestaurantModel::class);
        $session = session();
        $data = $RestaurantModel->where('status', 1)->findAll();
        $data['restaurant_list'] = $data;
        return view('super_admin/restaurants/restaurant_List', $data);
    }
    public function restaurantManagement($id='')
    {
        $RestaurantModel = model(RestaurantModel::class);
        $session = session();
        if($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required',
            'address'  => 'required',
            //'image'  => 'required',
]))
        {
            $imageValidation=1;
            // $imageValidation = $this->validate([
            //     'image' => [
            //         'uploaded[image]',
            //         'mime_in[image, image/png, image/jpg, image/jpeg]',
            //         'max_size[image,4096]',
            //     ]
            // ]);
            // if (!$imageValidation) {
                // $session->setFlashdata('error', 'Image type is wrong');
            // }
            // else{
                $newName = '';
                // $imageFile = $this->request->getFile('image');
                // if(!empty($imageFile))
                // {
                    // $newName = $imageFile->getRandomName();
                    //$imageFile->move(WRITEPATH . 'uploads/restaurant_image',$newName);
                // }
                $name = $this->request->getPost('name');
                $address = $this->request->getPost('address');
                $id = $this->request->getPost('id');
                $data = array();
                if($id>0)
                {
                    $data = [
                        'name' => $name,
                        'address'    => $address,
                        'modified_at'    => date('Y-m-d H:i:s'),
                    ];
                    //echo $newName; exit;
                    if(!empty($newName))
                    {
                        $data['image'] = $newName;
                    }
                }
                else{
                    $data = [
                        'name' => $name,
                        'address'    => $address,
                        'image'    => $newName,
                        'status'    => 1,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'modified_at'    => date('Y-m-d H:i:s'),
                    ];
                }
                
                if($id>0)
                {
                    if($RestaurantModel->update($id, $data))
                    {
                        $session->setFlashdata('success', 'Record updated successfully');
                        return redirect()->to('super-admin-restaurant-list');
                    }
                    else{
                        $session->setFlashdata('error', 'data not inserted, please try later.');
                    }
                }
                else{
                    if($RestaurantModel->insert($data))
                    {
                        $session->setFlashdata('success', 'Record inserted successfully');
                        return redirect()->to('super-admin-restaurant-list');
                    }
                    else{
                        $session->setFlashdata('error', 'data not inserted, please try later.');
                    }
                }
                
            
        }
        $RestaurantModel = model(RestaurantModel::class);
        $data = [];
        if($id > 0)
        {
            $data = $RestaurantModel->where('id', $id)->first();
        }
        $data['restaurant_list'] = $data;
        $data['id'] = $id;
        return view('super_admin/restaurants/restaurant_management', $data);
    }
    public function deleteRestaurant($id='')
    {
        $RestaurantModel = model(RestaurantModel::class);
        $session = session();
        if($id>0)
        {
            if($RestaurantModel->delete($id))
            {
                $session->setFlashdata('success', 'Record deleted successfully');
                return redirect()->to('super-admin-restaurant-list');
            }
            else{
                $session->setFlashdata('error', 'Record not deleted, try after sometime');
                return redirect()->to('super-admin-restaurant-list');
            }
        }
    }
    public function updateStatus()
    {
        $RestaurantModel = model(RestaurantModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0);
        if ($this->request->isAJAX()) {
            //$id = service('request')->getPost('id');
            $id =  service('request')->getPost('id');
            //echo $id; exit;
            $status =  service('request')->getPost('status'); //$this->request->getPost('status');
            //echo $status; exit;
            $data = array();
            $data['status'] = $status;
            if($id > 0 && $RestaurantModel->update($id, $data))
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