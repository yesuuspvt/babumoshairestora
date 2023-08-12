<?php
namespace App\Controllers\super_admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\super_admin\CategoryModel;
class Category extends BaseController 
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
    public function categoryList()
    {
        $CategoryModel = model(CategoryModel::class);
        $session = session();
        $data = $CategoryModel->where('status', 1)->findAll();
        $data['category_list'] = $data;
        return view('super_admin/categories/category_List', $data);
    }
    public function categoryManagement($id='')
    {
        $CategoryModel = model(CategoryModel::class);
        $session = session();
        if($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required',
        ]))
        {
            $name = $this->request->getPost('name');
            $id = $this->request->getPost('id');
            $data = array();
            if($id>0)
            {
                $data = [
                    'name' => $name,
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
            }
            else{
                $data = [
                    'name' => $name,
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
            }
            
            if($id>0)
            {
                if($CategoryModel->update($id, $data))
                {
                    $session->setFlashdata('success', 'Record updated successfully');
                    return redirect()->to('categories-list');
                }
                else{
                    $session->setFlashdata('error', 'data not inserted, please try later.');
                }
            }
            else{
                if($CategoryModel->insert($data))
                {
                    $session->setFlashdata('success', 'Record inserted successfully');
                    return redirect()->to('categories-list');
                }
                else{
                    $session->setFlashdata('error', 'data not inserted, please try later.');
                }
            }
        }
        $CategoryModel = model(CategoryModel::class);
        $data = [];
        if($id > 0)
        {
            $data = $CategoryModel->where('id', $id)->first();
        }
        $data['category_list'] = $data;
        $data['id'] = $id;
        return view('super_admin/categories/category_management', $data);
    }
    public function deleteCategory($id='')
    {
        $CategoryModel = model(CategoryModel::class);
        $session = session();
        if($id>0)
        {
            if($CategoryModel->delete($id))
            {
                $session->setFlashdata('success', 'Record deleted successfully');
                return redirect()->to('categories-list');
            }
            else{
                $session->setFlashdata('error', 'Record not deleted, try after sometime');
                return redirect()->to('categories-list');
            }
        }
    }
    public function updateStatus()
    {
        $CategoryModel = model(CategoryModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0);
        if ($this->request->isAJAX()) {
            //$id = service('request')->getPost('id');
            $id =  service('request')->getPost('id');
            //echo $id; exit;
            $status =  service('request')->getPost('status'); //$this->request->getPost('status');
            //echo $status; exit;
            $data = array();
            $data['status'] = $status;
            if($id > 0 && $CategoryModel->update($id, $data))
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