<?php 
namespace App\Models\super_admin;  
use CodeIgniter\Model;
  
class CategoryModel extends Model{
    protected $table = 'categories';
    
    protected $allowedFields = [
        'name',
        'status',
        'created_at',
    ];
}