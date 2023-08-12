<?php 
namespace App\Models\admin;  
use CodeIgniter\Model;
  
class OrderitemModel extends Model{
    protected $table = 'orderitems';
    
    protected $allowedFields = [
        'order_id', 
        'user_id', 
        'product_id', 
        'product_amount',
        'quantity',
        'is_kot_generated',
        'status', 
        'created_at',
    ];
}