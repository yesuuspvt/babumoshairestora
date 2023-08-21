<?php 
namespace App\Models\admin;  
use CodeIgniter\Model;
  
class OrderModel extends Model{
    protected $table = 'orders';
    
    protected $allowedFields = [
        'user_id', 
        'order_id', 
        'invoice_no',
        'order_amount', 
        'discount_type',
        'discount_percentage',
        'discount_amount', 
        'gst_percentage', 
        'gst_amount', 
        'total_amount',
        'total_amount_after_gst',
        'payment_type',
        'order_type',
        'table_no', 
        'customer_name', 
        'customer_mobile', 
        'customer_address', 
        'customer_aadhar_no', 
        'customer_pin',
        'is_order_final',
        'status', 
        'created_at'
    ];
}