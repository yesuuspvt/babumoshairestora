<?php 
namespace App\Models\super_admin;  
use CodeIgniter\Model;
  
class ProductimageModel extends Model{
    protected $table = 'productimages';
    
    protected $allowedFields = [
        'product_id',
        'image',
        'status',
    ];
}