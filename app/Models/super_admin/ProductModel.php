<?php 
namespace App\Models\super_admin;  
use CodeIgniter\Model;
  
class ProductModel extends Model{
    protected $table = 'products';
    
    protected $allowedFields = [
        'unit',
        'category_id',
        'name',
        'gst',
        'price',
        'is_available',
        'created_at',
        'modified_at',
    ];
}