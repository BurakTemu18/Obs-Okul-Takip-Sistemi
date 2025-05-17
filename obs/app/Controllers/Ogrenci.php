<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\GradeModel;
use App\Models\AbsenceModel;

class Ogrenci extends BaseController
{
    public function dashboard()
    {
        requireLogin('ogrenci');
        $studentModel = new StudentModel();
        $gradeModel = new GradeModel();
        $absenceModel = new AbsenceModel();

        $userId = session()->get('user_id');

        
        $student = $studentModel->where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->to('/login')->with('error', 'Öğrenci bulunamadı.');
        }

        $grades = $gradeModel->where('student_id', $student['id'])->findAll();
        $absences = $absenceModel->where('student_id', $student['id'])->findAll();

        return view('ogrenci/dashboard', [
            'student' => $student,
            'grades' => $grades,
            'absences' => $absences
        ]);
    }
}