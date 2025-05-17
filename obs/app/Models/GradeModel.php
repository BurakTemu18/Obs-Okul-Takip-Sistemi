<?php
namespace App\Models;
use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = 'grades';
    protected $allowedFields = ['student_id', 'subject', 'exam1', 'exam2', 'performance', 'teacher_id'];
}