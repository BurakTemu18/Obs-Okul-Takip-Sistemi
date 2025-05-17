<?php
namespace App\Models;
use CodeIgniter\Model;

class AbsenceModel extends Model
{
    protected $table = 'absences';
    protected $allowedFields = ['student_id', 'date', 'type'];
    
}