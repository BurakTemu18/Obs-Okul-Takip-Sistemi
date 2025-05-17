<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $allowedFields = ['user_id', 'name', 'student_no', 'class'];
}