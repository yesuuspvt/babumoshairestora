<?php 
namespace App\Models\super_admin;  
use CodeIgniter\Model;
  
class UserModel extends Model{
    protected $table = 'users';
    
    protected $allowedFields = [
        'username',
        'password',
        'role',
        'restaurant_id',
        'full_name',
        'address',
        'mobile',
        'email',
        'shift',
        'gender',
        'is_active',
        'created_at',
        'modified_at',
    ];
}