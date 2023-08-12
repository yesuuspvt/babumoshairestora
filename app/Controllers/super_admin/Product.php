<?php
namespace App\Controllers\super_admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\super_admin\RestaurantModel;
use App\Models\super_admin\ProductModel;
use App\Models\super_admin\ProductimageModel;
use App\Models\super_admin\CategoryModel;
class Product extends BaseController 
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
    public function productList()
    {
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $CategoryModel = model(CategoryModel::class);
        $session = session();
        $data = [];
        $product_category_data = $CategoryModel->where('status', 1)->findAll();
        $productCategories = [];
        if(!empty($product_category_data))
        {
          foreach($product_category_data as $pcd)
          {
            $productCategories[$pcd['id']] = $pcd['name'];
          }  
        }
        
        $product_data = $ProductModel->where('is_available', 1)->orderBy('id', 'DESC')->findAll(); //->join($ProductimageModel, $ProductimageModel.product_id = $ProductModel.id)
        if(!empty($product_data))
        {
            foreach($product_data as $pd)
            {
                $temp = array();
                $temp['id'] = $pd['id'];
                $temp['restaurant_id'] = $pd['restaurant_id'];
                $temp['category_id'] = $pd['category_id'];
                $temp['name'] = $pd['name'];
                $temp['price'] = $pd['price'];
                $temp['description'] = $pd['description'];
                $temp['is_available'] = $pd['is_available'];
                $temp['created_at'] = $pd['created_at'];
                $temp['images'] = array();
                $productimage = $ProductimageModel->where('product_id',$pd['id'])->findAll();
                if(!empty($productimage))
                {
                    foreach($productimage as $pimg)
                    {
                        $tempImg = array();
                        $tempImg['id'] = $pimg['id'];
                        $tempImg['product_id'] = $pimg['product_id'];
                        $tempImg['image'] = $pimg['image'];
                        $tempImg['status'] = $pimg['status'];
                        array_push($temp['images'], $tempImg);
                    }
                }
                array_push($data, $temp);
            }
        }
        // echo '<pre>';
        // print_r($data); 
        // exit;
        $RestaurantModel = model(RestaurantModel::class);
        $restaurant_data = $RestaurantModel->where('status', 1)->findAll();
        $restaurantlist = [];
        if(!empty($restaurant_data))
        {
            foreach($restaurant_data as $rd)
            {
                $restaurantlist[$rd['id']] = $rd['name'];
            }
        }
        //print_r($productCategories);exit;
        $data['product_list'] = $data;
        $data['product_category'] = $productCategories;
        $data['restaurant_list'] = $restaurantlist;
        return view('super_admin/products/product_list', $data);
    }
    public function productManagement($id='')
    {
        $ProductModel = model(ProductModel::class);
        $CategoryModel = model(CategoryModel::class);
        $product_category_data = $CategoryModel->where('status', 1)->findAll();
        $productCategories = [];
        if(!empty($product_category_data))
        {
          foreach($product_category_data as $pcd)
          {
            $productCategories[$pcd['id']] = $pcd['name'];
          }  
        }
        $session = session();
        if($this->request->getMethod() === 'post' && $this->validate([
            'restaurant_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
        ]))
        {
            $id = $this->request->getPost('id');
            $restaurant_id = $this->request->getPost('restaurant_id');
            $name = $this->request->getPost('name');
            $description = $this->request->getPost('description');
            $category_id = $this->request->getPost('category_id');
            $price = $this->request->getPost('price');
            //echo "validation"; exit;
            $insertORUpdateRecordId = 0;
            $data = [];
            if($id>0)
            {
                $data = [
                    'restaurant_id' => $restaurant_id,
                    'name' => $name,
                    'description'    => $description,
                    'category_id'    => $category_id,
                    'price'    => $price,
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
                    'restaurant_id' => $restaurant_id,
                    'name' => $name,
                    'description'    => $description,
                    'category_id'    => $category_id,
                    'price'    => $price,
                    'is_available'    => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'modified_at'    => date('Y-m-d H:i:s'),
                ];
            }
            if($id>0)
            {
                if($ProductModel->update($id, $data))
                {
                    $insertORUpdateRecordId = $id;
                    // $session->setFlashdata('success', 'Record updated successfully');
                    // return redirect()->to('super-admin-product-list');
                }
                else{
                    $session->setFlashdata('error', 'data not updated, please try later.');
                }
            }
            else{

                $checkProductExists = $ProductModel->select("*")->where("name",$name)->find();
                if(sizeof($checkProductExists)==0)
                {
                    if($ProductModel->insert($data))
                    {
                        $insertORUpdateRecordId =  $ProductModel->insertID(); 
                        // $session->setFlashdata('success', 'Record inserted successfully');
                        // return redirect()->to('super-admin-product-list');
                    }
                    else{
                        $session->setFlashdata('error', 'data not inserted, please try later.');
                    }
                }
                else
                {
                    $session->setFlashdata('error', 'Item is already exists');
                }
                
            }

            //Image Uploading
            if($insertORUpdateRecordId>0)
            {
                if (!empty($this->request->getFileMultiple('images')) && count($this->request->getFileMultiple('images')) > 0) {
                    $isImageUploaded = 1;
                    foreach($this->request->getFileMultiple('images') as $file)
                    {   
                        // echo 'Path Mime : '.$file->getBasename().'<br>'; 
                        // print_r($file); 
                        // exit;
                        if(!empty($file) && !empty($file->getBasename()))
                        {
                            $newName = $file->getRandomName();
                            if($file->move(WRITEPATH . 'uploads/product_image',$newName))
                            {
                                $productimageModel = model(ProductimageModel::class);
                                $ProductImageData = [
                                    'product_id' =>  $insertORUpdateRecordId,
                                    'image'  => $newName,
                                    'status'  => 1,
                                ];
                                if($productimageModel->insert($ProductImageData))
                                {
                                    $isImageUploaded = 1;
                                }
                                else{
                                    $isImageUploaded = 0;
                                }
                            }
                        }
                    }
                    if($isImageUploaded == 1)
                    {
                        $session->setFlashdata('success', 'Record is saved successfully');
                        return redirect()->to('super-admin-product-list');
                    }
                    else{
                        $session->setFlashdata('error', 'All images are not saved successfully');
                        return redirect()->to('super-admin-product-list');
                    }
                }
                else
                {
                    $session->setFlashdata('success', 'Record is saved successfully');
                    return redirect()->to('super-admin-product-list');
                }
            }
            else{
                $session->setFlashdata('error', 'Product not saved successfully Or Exists');
                return redirect()->to('super-admin-product-list');
            }
        }
        $ProductModel = model(ProductModel::class);
        $RestaurantModel = model(RestaurantModel::class);
        $restaurant_data = $RestaurantModel->where('status', 1)->findAll();
        $restaurantlist = [];
        if(!empty($restaurant_data))
        {
            foreach($restaurant_data as $rd)
            {
                $restaurantlist[$rd['id']] = $rd['name'];
            }
        }
        $data = [];
        if($id > 0)
        {
            $data = $ProductModel->where('id', $id)->first();
        }
        $data['product_list'] = $data;
        $data['restaurant_list'] = $restaurantlist;
        $data['product_category'] = $productCategories;
        $data['id'] = $id;
        return view('super_admin/products/product_management', $data);
    }
    public function deleteProductImage()
    {
        $ProductimageModel = model(ProductimageModel::class);
        $session = session();
        $res = array('SUCCESS'=>0, 'ERROR'=>0);
        if ($this->request->isAJAX()) {
            $id =  service('request')->getPost('id');
            if($id>0)
            {
                if($ProductimageModel->delete($id))
                {
                    $res['SUCCESS'] = 1;
                    $res['ERROR'] = 0;
                }
                else{
                    $res['SUCCESS'] = 0;
                    $res['ERROR'] = 1;
                }
            }
            else{
                $res['SUCCESS'] = 0;
                $res['ERROR'] = 1;
            }
        }
        else{
            $res['SUCCESS'] = 0;
            $res['ERROR'] = 1;
        }
        echo json_encode($res);
    }
    public function updateStatus()
    {
        $ProductModel = model(ProductModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0);
        if ($this->request->isAJAX()) {
            //$id = service('request')->getPost('id');
            $id =  service('request')->getPost('id');
            //echo $id; exit;
            $status =  service('request')->getPost('status'); //$this->request->getPost('status');
            //echo $status; exit;
            $data = array();
            $data['is_available'] = $status;
            if($id > 0 && $ProductModel->update($id, $data))
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
    public function deleteProduct($id='')
    {
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $session = session();
        if($id>0)
        {
            if($ProductModel->delete($id))
            {
                $ProductimageModel->where('product_id', $id)->delete();
                $session->setFlashdata('success', 'Record deleted successfully');
                return redirect()->to('super-admin-product-list');
            }
            else{
                $session->setFlashdata('error', 'Record not deleted, try after sometime');
                return redirect()->to('super-admin-product-list');
            }
        }
    }
}