<?php 
namespace App\Models\super_admin;  
use CodeIgniter\Model;
  
class RestaurantModel extends Model{
    protected $table = 'restaurants';
    
    protected $allowedFields = [
        'name',
        'address',
        'image',
        'status',
        'created_at',
        'modified_at',
    ];
}