<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\super_admin\UserModel;
use App\Models\super_admin\RestaurantModel;
use App\Models\super_admin\ProductModel;
use App\Models\super_admin\ProductimageModel;
use App\Models\super_admin\CategoryModel;
use App\Models\admin\OrderModel;
use App\Models\admin\OrderitemModel;
class Order extends BaseController 
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
    public function makeOrder()
    {
        $session = session();
        $restaurant_id = $_SESSION['restaurant_id'];
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
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
        if($this->request->getMethod() === 'post')
        {
            $category_name = $this->request->getPost('category_name');
            $formdata = array('category_name'=>$category_name);
            $session->set($formdata);
        }
        $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->limit(30)->find();
        $product_data_list = array();
        if(!empty($products))
        {
            foreach($products as $product)
            {
                $temp = array();
                $temp['id'] = $product['id'];
                $temp['restaurant_id'] = $product['restaurant_id'];
                $temp['name'] = $product['name'];
                $temp['price'] = $product['price'];
                $temp['is_available'] = $product['is_available'];
                $temp['image'] = array();
                $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                if(!empty($productImages))
                {
                    foreach($productImages as $img)
                    {
                        array_push($temp['image'], $img['image']);
                    }
                }
                array_push($product_data_list, $temp);
            }
        }
        $session = session();
        $cardData = $this->cartDataForOrderPage();
        $data = [];
        $data['product_category_list'] = $productCategories;
        $data['product_list'] = $product_data_list;
        $data['kot_order_product_list'] = $cardData;
        return view('admin/order/make_order', $data);
    }
    public function makeQuickOrder()
    {
        $session = session();
        $restaurant_id = $_SESSION['restaurant_id'];
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
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
        if($this->request->getMethod() === 'post')
        {
            $category_name = $this->request->getPost('category_name');
            $formdata = array('category_name'=>$category_name);
            $session->set($formdata);
        }
        $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->findAll();
        $product_data_list = array();
        if(!empty($products))
        {
            foreach($products as $product)
            {
                $temp = array();
                $temp['id'] = $product['id'];
                $temp['restaurant_id'] = $product['restaurant_id'];
                $temp['name'] = $product['name'];
                $temp['price'] = $product['price'];
                $temp['is_available'] = $product['is_available'];
                $temp['image'] = array();
                $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                if(!empty($productImages))
                {
                    foreach($productImages as $img)
                    {
                        array_push($temp['image'], $img['image']);
                    }
                }
                array_push($product_data_list, $temp);
            }
        }
        $session = session();
        $data = [];
        $data['product_category_list'] = $productCategories;
        $data['product_list'] = $product_data_list;
        return view('admin/order/make_quick_order', $data);
    }
    public function addToBill()
    {
        $session = session();
        $ProductModel = model(ProductModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $id =  service('request')->getPost('id');
            if($id>0)
            {
                $productData = $ProductModel->where('id', $id)->first();
                //print_r( $productData); exit;
                $cartItems = 0;
                if(!empty($productData))
                {
                    if(!empty($session->get('orderIds')))
                    {
                        
                        if(!in_array($id, $session->get('orderIds')))
                        {
                            $orderItems = $session->get('orderIds');
                            array_push($orderItems, $id);
                            $cartItems = count($orderItems);
                            $session->set('orderIds', $orderItems);
                        }
                        else{
                            $orderItems = $session->get('orderIds');
                            $cartItems = count($orderItems);
                        }
                    }
                    else{
                        $session->set('orderIds', array($id));
                        $cartItems = 1;
                    }
                    $kot_order_product_list = $this->cartDataForOrderPage();
                    if(!empty($kot_order_product_list) && count($kot_order_product_list)>0){
                    $htmlContent='<table class="table table-responsive-md" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <td><strong>Name</strong></td>
                                <td><strong>Product Price</strong></td>
                                <td><strong>Qunatity</strong></td>
                                <td><strong>Action</strong></td>
                            </tr>
                        </thead>
                        <tbody>';
                                $i = 1;
                                foreach($kot_order_product_list as $pl)
                                {
                                  
                                    $htmlContent .='<tr id="product_id_'.$pl['id'].'">
                                        <td>'.$pl['name'].'</td>
                                        <td>'.$pl['price'].'</td>
                                        <td><input size="2" name="quantity_'.$pl['id'].'" value="0" onchange="updateQuantity(this.value, '.$pl['id'].', '.$pl['price'].')" /></td>
                                        <td><a class="btn btn-danger shadow btn-xs sharp" onclick="deleteItem('.$pl['id'].')"><i class="fa fa-trash"></i></a></td>
                                    </tr>';
                                }
                         
                                $htmlContent .='<tr>
                                <td colspan="2">Order Type</td>
                                <td>
                                    <select name="order_type" onchange="checkOrderType()">
                                        <option value="TABLE">Table</option>
                                        <option value="PERCEL">PERCEL</option>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr id="table_no_row">
                                <td colspan="2">Order Table No.</td>
                                <td><input size="2" type="number" name="order_table_no" onkeyup="checkTableNo(this.value)"  /></td>
                                <td>&nbsp;</td>
                            </tr>
                            
                            <tr>
                                <td colspan="7"><button type="submit" class="btn btn-primary btn-sm" disabled="true" id="generate_kot">Generate KOT</button></td>
                            </tr>
                            
                        </tbody>
                    </table>';
                    } else{
                        $htmlContent='<p>Cart Item not available</p>';
                    }
                    




                    $res['SUCCESS'] = 1;
                    $res['ERROR'] = 0; 
                    $res['DATA'] = $htmlContent; 
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
            echo json_encode($res); exit;
        }
    }
    public function cartData()
    {
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $session = session(); 
        $cartItems = $session->get('orderIds');
        if(!empty($cartItems) && count($cartItems) > 0)
        {
            $productLists = $ProductModel->whereIn('id', $cartItems)->findAll();
            $product_data_list = array();
            if(!empty($productLists))
            {
                foreach($productLists as $product)
                {
                    $temp = array();
                    $temp['id'] = $product['id'];
                    $temp['restaurant_id'] = $product['restaurant_id'];
                    $temp['name'] = $product['name'];
                    $temp['price'] = $product['price'];
                    $temp['is_available'] = $product['is_available'];
                    $temp['image'] = array();
                    $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                    if(!empty($productImages))
                    {
                        foreach($productImages as $img)
                        {
                            array_push($temp['image'], $img['image']);
                        }
                    }
                    array_push($product_data_list, $temp);
                }
            }
        }
        else{
            $session->setFlashdata('error', 'Please add product to cart');
            return redirect()->to('orders');
        }
        $data = [];
        $data['product_list'] = $product_data_list;
        return view('admin/order/cart', $data);
    }
    public function cartDataForOrderPage()
    {
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $session = session(); 
        $cartItems = $session->get('orderIds');
        $product_data_list = array();
        if(!empty($cartItems) && count($cartItems) > 0)
        {
            $productLists = $ProductModel->whereIn('id', $cartItems)->findAll();
            if(!empty($productLists))
            {
                foreach($productLists as $product)
                {
                    $temp = array();
                    $temp['id'] = $product['id'];
                    $temp['restaurant_id'] = $product['restaurant_id'];
                    $temp['name'] = $product['name'];
                    $temp['price'] = $product['price'];
                    $temp['is_available'] = $product['is_available'];
                    $temp['image'] = array();
                    $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                    if(!empty($productImages))
                    {
                        foreach($productImages as $img)
                        {
                            array_push($temp['image'], $img['image']);
                        }
                    }
                    array_push($product_data_list, $temp);
                }
            }
        }
        // else{
        //     $session->setFlashdata('error', 'Please add product to cart');
        //     return redirect()->to('orders');
        // }
        return $product_data_list;
    }
    public function deleteCartItem()
    {
        //echo 'test'; exit;
        $session = session();
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $id = service('request')->getPost('id');
            if($id>0)
            {
                if(!empty($session->get('orderIds')))
                {
                    $cartItems = $session->get('orderIds');
                    $ids = array($id);
                    $orderItems = array_diff($cartItems, $ids);                    
                    $session->set('orderIds', $orderItems);
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
            echo json_encode($res); exit;
        }
    }
    public function placeOrder()
    {
        $ProductModel = model(ProductModel::class);
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $session = session();
        if($this->request->getMethod() === 'post')
        {
            $postData = $this->request->getPost();
            $prodctIds = $session->get('orderIds');
            if(!empty($prodctIds))
            {
                $orderAmount = 0;
                $discountAmount = $this->request->getPost('discount')?$this->request->getPost('discount'):0;
                $totalAmount = 0;
                $gstAmount=0;
                foreach($prodctIds as $pid)
                {
                    $qty = $this->request->getPost('quantity_'.$pid);
                    $product = $ProductModel->where('id', $pid)->first();
                    $orderAmount += ($product['price']*$qty);
                    $gstAmount  +=($product['gst'] *$product['price']*$qty/100);
                }
                $totalAmount = ($orderAmount-$discountAmount);
                $orderData = [];
                $orderData['user_id'] = $_SESSION['id'];
                $orderData['order_id'] = '';
                $orderData['order_amount'] = $orderAmount;
                $orderData['discount_amount'] = $discountAmount;
                $orderData['total_amount'] = $totalAmount;
                $orderData['gst_amount'] = $gstAmount;
                $orderData['total_amount_after_gst'] = $totalAmount+$gstAmount;
                $orderData['table_no'] = $this->request->getPost('order_table_no');
                $orderData['customer_name'] = ''; //$this->request->getPost('customer_name');
                $orderData['customer_mobile'] = ''; //$this->request->getPost('customer_phone');
                $orderData['customer_address'] = ''; //$this->request->getPost('customer_address');
                $orderData['order_type'] = $this->request->getPost('order_type');
                $orderData['status'] = 1;
                $orderData['created_at'] = date('Y-m-d H:i:s');
                if($OrderModel->insert($orderData))
                {
                   $order_id = $OrderModel->getInsertID();
                   $order = $OrderModel->where('id', $order_id)->first();
                   $orderCode = 'ORD'.$order_id;
                   $invoiceCode = str_pad($order_id,10,0,STR_PAD_LEFT);
                   $updateOrder = [];
                   $updateOrder['order_id'] = $orderCode;
                   $updateOrder['invoice_no'] = $invoiceCode;
                   $OrderModel->update($order_id, $updateOrder);
                   $isOrderitemInserted = 1;
                   foreach($prodctIds as $pid)
                   {
                        $product = $ProductModel->where('id', $pid)->first();
                       $orderItem = [];
                       $orderItem['order_id'] = $order_id;
                       $orderItem['user_id'] = $_SESSION['id'];
                       $orderItem['product_id'] = $pid;
                       $orderItem['quantity'] = $this->request->getPost('quantity_'.$pid);
                       $orderItem['product_gst_percentage'] = $product['gst'];
                       $orderItem['product_gst_amount'] = $product['gst']*$product['price']/100;
                       $orderItem['product_amount'] = $product['price'];
                       $orderItem['product_amount_after_gst'] = $product['price']+$orderItem['product_gst_amount'];
                       $orderItem['status'] = 1;
                       $orderItem['created_at'] = date('Y-m-d H:i:s');
                       if($OrderitemModel->insert($orderItem))
                       {
                            $isOrderitemInserted = 1;
                       }
                       else{
                            $isOrderitemInserted = 0;
                       }
                   }
                   if($isOrderitemInserted==1)
                   {
                        $session->remove('orderIds');
                        $session->setFlashdata('error', 'Something went wrong, try later');
                        $data['order'] = $OrderModel->where('id', $order_id)->first();
                        $data['orderitem'] = $OrderitemModel->where('order_id', $order_id)->findAll();
                        //return view('admin/order/printOrder', $data);
                        //return redirect()->to('print-orders/'.$order_id);
                        return redirect()->to(site_url("print-kot-orders/".$order_id));
                        
                   }
                   else{
                        $session->setFlashdata('error', 'Order not saved, try later');
                        return redirect()->to('admin/order/cartData');
                   }
                }
                else{
                    $session->setFlashdata('error', 'Something went wrong, try later');
                    return redirect()->to('admin/order/cartData');
                }
            }
            else{
                $session->setFlashdata('error', 'Product not found');
                return redirect()->to('admin/order/cartData');
            }
        }
    }
    public function printKotOrder($order_id=false)
    {
        $ProductModel = model(ProductModel::class);
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        // echo '<br>ljslfjslfj '.$seg1;
        // exit;
        $data = [];
        $ordereditems = [];
        $data['order'] = $OrderModel->where('id', $order_id)->first();
        $orderitems = $OrderitemModel->where('order_id', $order_id)->findAll();
        if(!empty($orderitems))
        {
            foreach($orderitems as $orderitem)
            {
                $temp = [];
                $productdetails = $ProductModel->where('id', $orderitem['product_id'])->first();
                $temp['order_id']=$orderitem['order_id'];
                $temp['user_id']=$orderitem['user_id'];
                $temp['product_id']=$orderitem['product_id'];
                $temp['quantity']=$orderitem['quantity'];
                $temp['product_amount']=$orderitem['product_amount'];
                $temp['is_kot_generated']=$orderitem['is_kot_generated'];
                $temp['product']=$productdetails;
                array_push($ordereditems, $temp);
            }
        }
        if(!empty($ordereditems))
        {
            foreach($orderitems as $orderitem)
            {
                $orderitemid = $orderitem['id'];
                $data['is_kot_generated'] = 1;
                $OrderitemModel->update($orderitemid, $data);
            }
        }
        // echo '<pre>';
        // print_r($data); exit;
        $data['orderitem'] = $ordereditems;
        return view('admin/order/printKotOrder', $data);
    }
    public function printOrder($order_id=false)
    {
        $ProductModel = model(ProductModel::class);
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        // echo '<br>ljslfjslfj '.$seg1;
        // exit;
        $data = [];
        $ordereditems = [];
        $data['order'] = $OrderModel->where('id', $order_id)->first();
        $orderitems = $OrderitemModel->where('order_id', $order_id)->findAll();
        if(!empty($orderitems))
        {
            foreach($orderitems as $orderitem)
            {
                $temp = [];
                $productdetails = $ProductModel->where('id', $orderitem['product_id'])->first();
                $temp['order_id']=$orderitem['order_id'];
                $temp['user_id']=$orderitem['user_id'];
                $temp['product_id']=$orderitem['product_id'];
                $temp['quantity']=$orderitem['quantity'];
                $temp['product_amount']=$orderitem['product_amount'];
                $temp['is_kot_generated']=$orderitem['is_kot_generated'];
                $temp['product']=$productdetails;
                array_push($ordereditems, $temp);
            }
        }
        if(!empty($ordereditems))
        {
            $data['is_order_final'] = 1;
            $OrderModel->update($order_id, $data);
        }
        // echo '<pre>';
        // print_r($data); exit;
        $data['orderitem'] = $ordereditems;
        return view('admin/order/printOrder', $data);
    }
    public function productLoading()
    {
        $session = session();
        $restaurant_id = $_SESSION['restaurant_id'];
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>'');
        if ($this->request->isAJAX()) {
            $categoryId =  service('request')->getPost('id');
            $product_name = service('request')->getPost('product_name');
            $products = [];
            $product_list = [];
            if(!empty($categoryId) && count($categoryId)>0)
            {
                if($prodct_name == "")
                {
                    $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->whereIn('category_id',$categoryId)->find();
                }
                else
                {
                    $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->whereIn('category_id',$categoryId)->where("name like '%$product_name%' OR id='$product_name'")->find();
                }
                
            }
            else{
                if($product_name == "")
                {
                    $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->limit(10)->find();
                }
                else
                {
                    $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->where("name like '%$product_name%' OR id='$product_name'")->find();
                }
                
            }
            foreach($products as $product)
            {
                $temp = array();
                $temp['id'] = $product['id'];
                $temp['restaurant_id'] = $product['restaurant_id'];
                $temp['name'] = $product['name'];
                $temp['price'] = $product['price'];
                $temp['is_available'] = $product['is_available'];
                $temp['image'] = array();
                $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                if(!empty($productImages))
                {
                    foreach($productImages as $img)
                    {
                        array_push($temp['image'], $img['image']);
                    }
                }
                array_push($product_list, $temp);
            }
            if(!empty($product_list))
            {
                $i=0;
                $htmlContent = '';
                foreach($product_list as $pl)
                {
                    $htmlContent .='<div class="col-lg-4 col-md-6 '; if($i>0){ $htmlContent .='pt-md-0 pt-3'; } $htmlContent .='">
                        <div class="card d-flex flex-column align-items-center" style="height: unset;">
                            <div class="product-name">';
                            if(strlen($pl['name'])>14){
                                $htmlContent .= substr($pl['name'],0,12).'...';
                            }else{
                                $htmlContent .=$pl['name'];
                            }
                            $htmlContent .='</div>
                            <div class="card-img">';
                            if(!empty($pl['image']) && count($pl['image'])>0) {
                                $htmlContent .='<img style="padding-top: 0px; height:90px; object-fit: unset;" src="'.site_url().'writable/uploads/product_image/'.$pl['image'][0].'" alt="">';
                             }else{
                                $htmlContent .='<img style="padding-top: 0px; height:90px; object-fit: unset;" src="'.site_url().'assets/img/BABUMOSHAI.png'.'" alt="" > ';
                            }
                            $htmlContent .='</div>
                            <div class="card-body pt-5">
                                <div class="d-flex align-items-center price">
                                    <div class="del mr-2"  style="text-decoration: none;font-size: 12px !important;"><span class="text-dark">'.$pl['price'].' INR</span></div>
                                </div>
                                <div class="del mr-2"><button style="font-size: 12px !important;" type="button" class="btn btn-primary btn-sm" onclick="addToBill('.$pl['id'].')">Add</button></div>
                            </div>
                        </div>
                    </div>';
                $i++;
                }
                if(!empty($product_list))
                {
                    $res['SUCCESS'] = 1;
                    $res['ERROR'] = 0;
                    $res['DATA'] =  $htmlContent;
                }
                else{
                    $res['SUCCESS'] = 0;
                    $res['ERROR'] = 1;
                    $res['DATA'] =  '';
                }
            }
            else{
                $res['SUCCESS'] = 0;
                $res['ERROR'] = 1;
                $res['DATA'] =  '';
            }
        }
        else{
            $res['SUCCESS'] = 0;
            $res['ERROR'] = 1;
            $res['DATA'] =  '';
        }
        echo json_encode($res); exit;
    }
    public function KotToFinalOrder()
    {
        $ProductModel = model(ProductModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $session = session();
        $OrderModelLists = $OrderModel
        // ->where('is_order_final', 0)
        ->orderBy('id','DESC')->findAll();
        $order_data_list = array();
        if(!empty($OrderModelLists))
        {
            foreach($OrderModelLists as $order)
            {
                $OrderitemList = $OrderitemModel->where('order_id', $order['id'])->findAll();
                $temp = array();
                $temp['id'] = $order['id'];
                $temp['user_id'] = $order['user_id'];
                $temp['order_id'] = $order['order_id'];
                $temp['invoice_no'] = $order['invoice_no'];
                $temp['order_amount'] = $order['order_amount'];
                $temp['discount_amount'] = $order['discount_amount'];
                $temp['total_amount'] = $order['total_amount'];
                $temp['table_no'] = $order['table_no'];
                $temp['is_order_final'] = $order['is_order_final'];
                $temp['order_type'] = $order['order_type'];
                $temp['order_items'] = array();
                if(!empty($OrderitemList))
                {
                    foreach($OrderitemList as $orderItem)
                    {
                        $productLists = $ProductModel->where('id', $orderItem['product_id'])->first();
                        $tempOrderItem = array();
                        $tempOrderItem['id'] = $orderItem['id']; 
                        $tempOrderItem['product_id'] = $orderItem['product_id']; 
                        $tempOrderItem['quantity'] = $orderItem['quantity']; 
                        $tempOrderItem['product_amount'] = $orderItem['product_amount']; 
                        $tempOrderItem['status'] = $orderItem['status']; 
                        $tempOrderItem['created_at'] = $orderItem['created_at']; 

                        $tempOrderItem['restaurant_id'] = $productLists['restaurant_id'];
                        $tempOrderItem['name'] = $productLists['name'];
                        $tempOrderItem['price'] = $productLists['price'];
                        $tempOrderItem['is_available'] = $productLists['is_available'];
                        $tempOrderItem['image'] = array();
                        $productImages = $ProductimageModel->where(['product_id'=> $orderItem['product_id']])->findAll();
                        if(!empty($productImages))
                        {
                            foreach($productImages as $img)
                            {
                                array_push($tempOrderItem['image'], $img['image']);
                            }
                        }
                        array_push($temp['order_items'], $tempOrderItem);
                    }
                }
                array_push($order_data_list, $temp);
            }
        }
        $data = [];
        $data['order_list'] = $order_data_list;
        return view('admin/order/final_order', $data);
    }
    public function editKotFinalOrder($order_id)
    {
        $restaurant_id = $_SESSION['restaurant_id'];
        $ProductModel = model(ProductModel::class);
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $CategoryModel = model(CategoryModel::class);
        // echo '<br>ljslfjslfj '.$seg1;
        // exit;
        $data = [];
        $ordereditems = [];
        $data['order'] = $OrderModel->where('id', $order_id)->first();
        $orderitems = $OrderitemModel->where('order_id', $order_id)->findAll();
        if(!empty($orderitems))
        {
            foreach($orderitems as $orderitem)
            {
                $temp = [];
                $productdetails = $ProductModel->where('id', $orderitem['product_id'])->first();
                $temp['order_id']=$orderitem['order_id'];
                $temp['user_id']=$orderitem['user_id'];
                $temp['product_id']=$orderitem['product_id'];
                $temp['quantity']=$orderitem['quantity'];
                $temp['product_amount']=$orderitem['product_amount'];
                $temp['is_kot_generated']=$orderitem['is_kot_generated'];
                $temp['product_image']= [];
                $productimage = $ProductimageModel->where('product_id',$orderitem['product_id'])->findAll();
                if(!empty($productimage))
                {
                    foreach($productimage as $pimg)
                    {
                        $tempImg = array();
                        $tempImg['id'] = $pimg['id'];
                        $tempImg['image'] = $pimg['image'];
                        array_push($temp['product_image'], $tempImg);
                    }
                }
                $temp['product']=$productdetails;
                array_push($ordereditems, $temp);
            }
        }
        $data['order_item'] = $ordereditems;
        $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->findAll();
        $product_data_list = array();
        if(!empty($products))
        {
            foreach($products as $product)
            {
                $temp = array();
                $temp['id'] = $product['id'];
                $temp['restaurant_id'] = $product['restaurant_id'];
                $temp['name'] = $product['name'];
                $temp['price'] = $product['price'];
                $temp['is_available'] = $product['is_available'];
                $temp['image'] = array();
                $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                if(!empty($productImages))
                {
                    foreach($productImages as $img)
                    {
                        array_push($temp['image'], $img['image']);
                    }
                }
                array_push($product_data_list, $temp);
            }
        }
        $product_category_data = $CategoryModel->where('status', 1)->findAll();
        $productCategories = [];
        if(!empty($product_category_data))
        {
          foreach($product_category_data as $pcd)
          {
            $productCategories[$pcd['id']] = $pcd['name'];
          }  
        }
        $data['product_category_list'] = $productCategories;
        $data['product_list'] = $product_data_list;
        //end product listiing data
        // echo '<pre>';
        // print_r($data); exit;
        return view('admin/order/edit_kot_final_order', $data);
    }
    public function editGenerateFinalBill($order_id)
    {
        $restaurant_id = $_SESSION['restaurant_id'];
        $ProductModel = model(ProductModel::class);
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $ProductimageModel = model(ProductimageModel::class);
        $CategoryModel = model(CategoryModel::class);
        // echo '<br>ljslfjslfj '.$seg1;
        // exit;
        $data = [];
        $ordereditems = [];
        $data['order'] = $OrderModel->where('id', $order_id)->first();
        $orderitems = $OrderitemModel->where('order_id', $order_id)->findAll();
        if(!empty($orderitems))
        {
            foreach($orderitems as $orderitem)
            {
                $temp = [];
                $productdetails = $ProductModel->where('id', $orderitem['product_id'])->first();
                $temp['order_id']=$orderitem['order_id'];
                $temp['user_id']=$orderitem['user_id'];
                $temp['product_id']=$orderitem['product_id'];
                $temp['quantity']=$orderitem['quantity'];
                $temp['product_amount']=$orderitem['product_amount'];
                $temp['is_kot_generated']=$orderitem['is_kot_generated'];
                $temp['product_image']= [];
                $productimage = $ProductimageModel->where('product_id',$orderitem['product_id'])->findAll();
                if(!empty($productimage))
                {
                    foreach($productimage as $pimg)
                    {
                        $tempImg = array();
                        $tempImg['id'] = $pimg['id'];
                        $tempImg['image'] = $pimg['image'];
                        array_push($temp['product_image'], $tempImg);
                    }
                }
                $temp['product']=$productdetails;
                array_push($ordereditems, $temp);
            }
        }
        $data['order_item'] = $ordereditems;
        $products = $ProductModel->where(['is_available'=> 1,'restaurant_id'=>$restaurant_id])->findAll();
        $product_data_list = array();
        if(!empty($products))
        {
            foreach($products as $product)
            {
                $temp = array();
                $temp['id'] = $product['id'];
                $temp['restaurant_id'] = $product['restaurant_id'];
                $temp['name'] = $product['name'];
                $temp['price'] = $product['price'];
                $temp['is_available'] = $product['is_available'];
                $temp['image'] = array();
                $productImages = $ProductimageModel->where(['product_id'=> $product['id']])->findAll();
                if(!empty($productImages))
                {
                    foreach($productImages as $img)
                    {
                        array_push($temp['image'], $img['image']);
                    }
                }
                array_push($product_data_list, $temp);
            }
        }
        $product_category_data = $CategoryModel->where('status', 1)->findAll();
        $productCategories = [];
        if(!empty($product_category_data))
        {
          foreach($product_category_data as $pcd)
          {
            $productCategories[$pcd['id']] = $pcd['name'];
          }  
        }
        $data['product_category_list'] = $productCategories;
        $data['product_list'] = $product_data_list;
        //end product listiing data
        // echo '<pre>';
        // print_r($data); exit;
        return view('admin/order/edit_generate_final_bill', $data);
    }
    public function deleteKOTItem()
    {
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $order_id = service('request')->getPost('order_id');
            $product_id = service('request')->getPost('product_id');
            if($order_id > 0 && $product_id > 0)
            {
                $orderDetails = $OrderModel->where('id', $order_id)->first();
                if($OrderitemModel->where('product_id', $product_id)->where('order_id', $order_id)->delete())
                {
                    $orderItems = $OrderitemModel->where('order_id', $order_id)->findAll();
                    $OrderAmount = 0;
                    $totalOrderAmount = 0;
                    $discountAmount = $orderDetails['discount_amount'];
                    foreach($orderItems as $order_item)
                    {
                        $OrderAmount += ($order_item['product_amount'] * $order_item['quantity']);
                    }
                    $totalOrderAmount = $OrderAmount - $discountAmount;
                    $orderUpdateData = [];
                    $orderUpdateData['order_amount'] = $OrderAmount;
                    $orderUpdateData['total_amount'] = $totalOrderAmount;
                    if($order_id > 0 && $OrderModel->update($order_id, $orderUpdateData))
                    {
                        $res['SUCCESS'] = 1;
                        $res['ERROR'] = 0;
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
            echo json_encode($res); exit;
        }
    }
    public function updateKOTOrderQuantity()
    {
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $order_id = service('request')->getPost('order_id');
            $product_id = service('request')->getPost('product_id');
            $quantity = service('request')->getPost('quantity');
            if($order_id > 0 && $product_id > 0)
            {
                $orderDetails = $OrderModel->where('id', $order_id)->first();
                $orderItemDetails = $OrderitemModel->where('product_id', $product_id)->where('order_id', $order_id)->first();
                if(!empty($orderItemDetails))
                {
                    $orderItemUpdateData = [];
                    $orderItemUpdateData['quantity'] = $quantity;
                    if($orderItemDetails['id'] > 0)
                    {
                        $OrderitemModel->update($orderItemDetails['id'], $orderItemUpdateData);
                    }
                    $orderItems = $OrderitemModel->where('order_id', $order_id)->findAll();
                    $OrderAmount = 0;
                    $totalOrderAmount = 0;
                    $gstAmount=0;
                    $discountAmount = $orderDetails['discount_amount'];
                    foreach($orderItems as $order_item)
                    {
                        $OrderAmount += ($order_item['product_amount'] * $order_item['quantity']);
                        $gstAmount += ($order_item['product_amount'] * $order_item['quantity']*$order_item['product_gst_percentage']/100);
                    }
                    $totalOrderAmount = $OrderAmount - $discountAmount;
                    $orderUpdateData = [];
                    $orderUpdateData['order_amount'] = $OrderAmount;
                    $orderUpdateData['total_amount'] = $totalOrderAmount;
                    $orderUpdateData['gst_amount'] = $gstAmount;
                    $orderUpdateData['total_amount_after_gst'] = $totalOrderAmount+$gstAmount;
                    if($order_id > 0 && $OrderModel->update($order_id, $orderUpdateData))
                    {
                        $res['SUCCESS'] = 1;
                        $res['ERROR'] = 0;
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
            echo json_encode($res); exit;
        }
    }
    public function updateKOTOrderDiscountAmount()
    {
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $order_id = service('request')->getPost('order_id');
            $amount = service('request')->getPost('amount');
            if($order_id > 0)
            {
                $orderDetails = $OrderModel->where('id', $order_id)->first();
                if(!empty($orderDetails))
                {
                    $total_amount = $orderDetails['total_amount'];
                    $totalOrderAmount = $total_amount - $amount;
                    $orderUpdateData = [];
                    $orderUpdateData['discount_amount'] = $amount;
                    $orderUpdateData['total_amount'] = $totalOrderAmount;
                    $gstAmount=$orderUpdateData['gst_amount'];
                    $orderUpdateData['total_amount_after_gst'] = $totalOrderAmount+$gstAmount;
                    if($order_id > 0 && $OrderModel->update($order_id, $orderUpdateData))
                    {
                        $res['SUCCESS'] = 1;
                        $res['ERROR'] = 0;
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
            echo json_encode($res); exit;
        }
    }
    public function insertProductToKotOrder()
    {
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $ProductModel = model(ProductModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $order_id = service('request')->getPost('order_id');
            $product_id = service('request')->getPost('product_id');
            if($order_id > 0 && $product_id > 0)
            {
                $orderDetails = $OrderModel->where('id', $order_id)->first();
                $orderItemDetails = $OrderitemModel->where('product_id', $product_id)->where('order_id', $order_id)->first();
                if(!empty($orderItemDetails))
                {
                    $res['SUCCESS'] = 0;
                    $res['ERROR'] = 1;
                }
                else{
                    $productDetails = $ProductModel->where('id', $product_id)->first();
                    $orderItemData = [];
                    $orderItemData['order_id'] = $order_id;
                    $orderItemData['user_id'] = $orderDetails['user_id'];
                    $orderItemData['product_id'] = $productDetails['id'];
                    $orderItemData['quantity'] = 1;
                    $orderItemData['product_amount'] = $productDetails['price'];
                    $orderItemData['product_gst_percentage'] = $productDetails['gst'];
                    $orderItemData['product_gst_amount'] = ($productDetails['price']*$productDetails['gst']/100);
                    $orderItemData['product_amount_after_gst'] = $productDetails['price']+($productDetails['price']*$productDetails['gst']/100);
                    $orderItemData['is_kot_generated'] = 0;
                    $orderItemData['status'] = 1;
                    $orderItemData['created_at'] = date('Y-m-d');
                    $OrderitemModel->insert($orderItemData);              
                    $orderItems = $OrderitemModel->where('order_id', $order_id)->findAll();
                    $OrderAmount = 0;
                    $totalOrderAmount = 0;
                    $gstAmount=0;
                    $discountAmount = $orderDetails['discount_amount'];
                    foreach($orderItems as $order_item)
                    {
                        $OrderAmount += ($order_item['product_amount'] * $order_item['quantity']);
                        $gstAmount  +=($order_item['product_gst_amount'] * $order_item['quantity']);
                        
                    }
                    $totalOrderAmount = $OrderAmount - $discountAmount;
                    $orderUpdateData = [];
                    $orderUpdateData['order_amount'] = $OrderAmount;
                    $orderUpdateData['total_amount'] = $totalOrderAmount;
                    $orderUpdateData['gst_amount'] = $gstAmount;
                    $orderUpdateData['total_amount_after_gst'] = $totalOrderAmount+$gstAmount;
                    if($order_id > 0 && $OrderModel->update($order_id, $orderUpdateData))
                    {
                        $res['SUCCESS'] = 1;
                        $res['ERROR'] = 0;
                    }
                }
            }
            else{
                $res['SUCCESS'] = 0;
                $res['ERROR'] = 1;
            }
            echo json_encode($res); exit;
        }
    }
    public function deleteKotOrder()
    {
        $OrderModel = model(OrderModel::class);
        $OrderitemModel = model(OrderitemModel::class);
        $res = array('SUCCESS'=>0, 'ERROR'=>0,'DATA'=>0);
        if ($this->request->isAJAX()) {
            $order_id = service('request')->getPost('order_id');
            if($order_id > 0)
            {
                if($OrderitemModel->where('order_id', $order_id)->delete())
                {
                    if($OrderModel->where('id', $order_id)->delete())
                    {
                        $res['SUCCESS'] = 1;
                        $res['ERROR'] = 0;
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
            echo json_encode($res); exit;
        }
    }
}