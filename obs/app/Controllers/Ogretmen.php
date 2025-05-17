<?php

namespace App\Controllers;
use App\Models\StudentModel;
use App\Models\GradeModel;



class Ogretmen extends BaseController
{
    public function dashboard()
    {
        requireLogin('ogretmen');
        $studentModel = new StudentModel();
        $students = $studentModel->findAll();

        return view('ogretmen/dashboard', ['students' => $students]);
    }

    public function notEkle($studentId)
{
    requireLogin('ogretmen');
    $studentModel = new StudentModel();
    $student = $studentModel->find($studentId);

    if (!$student) {
        return redirect()->to('/ogretmen/dashboard')->with('error', 'Öğrenci bulunamadı.');
    }

    return view('ogretmen/not_ekle', ['student' => $student]);
}

public function notKaydet()
{
    requireLogin('ogretmen');
    $gradeModel = new \App\Models\GradeModel();
    $teacherModel = new \App\Models\TeacherModel();
    $teacher = $teacherModel->where('user_id', session()->get('user_id'))->first();

    $studentId = $this->request->getPost('student_id');
    $subject = $this->request->getPost('subject');

    // Not var mı kontrol et
    $existing = $gradeModel
        ->where('student_id', $studentId)
        ->where('subject', $subject)
        ->first();

    $data = [
        'student_id'  => $studentId,
        'subject'     => $subject,
        'exam1'       => $this->request->getPost('exam1') !== '' ? $this->request->getPost('exam1') : null,
        'exam2'       => $this->request->getPost('exam2') !== '' ? $this->request->getPost('exam2') : null,
        'performance' => $this->request->getPost('performance') !== '' ? $this->request->getPost('performance') : null,
        'teacher_id'  => $teacher['id']
    ];

    if ($existing) {
        // Güncelleme yap
        $gradeModel->update($existing['id'], array_filter($data, fn($v) => $v !== null));
    } else {
        // Yeni kayıt
        $gradeModel->insert($data);
    }

    return redirect()->to('/ogretmen/dashboard')->with('success', 'Not kaydedildi.');
}

public function devamsizlikEkle($studentId)
{
    requireLogin('ogretmen');
    $studentModel = new \App\Models\StudentModel();
    $student = $studentModel->find($studentId);

    if (!$student) {
        return redirect()->to('/ogretmen/dashboard')->with('error', 'Öğrenci bulunamadı.');
    }

    return view('ogretmen/devamsizlik_ekle', ['student' => $student]);
}

public function devamsizlikKaydet()
{
    requireLogin('ogretmen');
    $absenceModel = new \App\Models\AbsenceModel();

    $absenceModel->insert([
        'student_id' => $this->request->getPost('student_id'),
        'date'       => $this->request->getPost('date'),
        'type'       => $this->request->getPost('type')
    ]);

    return redirect()->to('/ogretmen/dashboard')->with('success', 'Devamsızlık başarıyla kaydedildi.');
}

public function gecmis()
{
    requireLogin('ogretmen');
    $teacherModel = new \App\Models\TeacherModel();
    $gradeModel = new \App\Models\GradeModel();
    $absenceModel = new \App\Models\AbsenceModel();
    $studentModel = new \App\Models\StudentModel();

    $teacher = $teacherModel->where('user_id', session()->get('user_id'))->first();

    if (!$teacher) {
        return redirect()->to('/ogretmen/dashboard')->with('error', 'Öğretmen bulunamadı.');
    }

    $grades = $gradeModel->where('teacher_id', $teacher['id'])->findAll();

    
    $students = [];
    foreach ($studentModel->findAll() as $s) {
        $students[$s['id']] = $s['name'];
    }

    
    $absences = $absenceModel->findAll();

    return view('ogretmen/gecmis', [
        'grades' => $grades,
        'students' => $students,
        'absences' => $absences
    ]);
}

public function ogrenciBilgi($id)
{
    requireLogin('ogretmen');

    $gradeModel = new \App\Models\GradeModel();
    $absenceModel = new \App\Models\AbsenceModel();
    $studentModel = new \App\Models\StudentModel();

    $ogrenci = $studentModel->find($id);
    if (!$ogrenci) {
        return redirect()->to('/ogretmen/dashboard')->with('error', 'Öğrenci bulunamadı.');
    }

    // Tüm not ve devamsızlık verileri (sahiplik kontrolü yok)
    $notlar = $gradeModel->where('student_id', $id)->findAll();
    $devamsizliklar = $absenceModel->where('student_id', $id)->findAll();

    return view('ogretmen/ogrenci_bilgi', [
        'ogrenci' => $ogrenci,
        'notlar' => $notlar,
        'devamsizliklar' => $devamsizliklar
    ]);
}

public function notSil($id)
{
    requireLogin('ogretmen');

    $gradeModel = new \App\Models\GradeModel();
    $grade = $gradeModel->find($id);

    if (!$grade) {
        return redirect()->back()->with('error', 'Not bulunamadı.');
    }

    $gradeModel->delete($id);
    return redirect()->back()->with('success', 'Not silindi.');
}

public function devamsizlikSil($id)
{
    requireLogin('ogretmen');

    $absenceModel = new \App\Models\AbsenceModel();
    $absence = $absenceModel->find($id);

    if (!$absence) {
        return redirect()->back()->with('error', 'Devamsızlık bulunamadı.');
    }

    $absenceModel->delete($id);
    return redirect()->back()->with('success', 'Devamsızlık silindi.');
}
}