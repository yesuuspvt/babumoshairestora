<?php 
namespace App\Models\super_admin;  
use CodeIgniter\Model;
  
class ProductModel extends Model{
    protected $table = 'products';
    
    protected $allowedFields = [
        'restaurant_id',
        'category_id',
        'name',
        'description',
        'price',
        'is_available',
        'created_at',
        'modified_at',
    ];
}