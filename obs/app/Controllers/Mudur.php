<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\TeacherModel;

class Mudur extends BaseController
{
    public function dashboard()
{
    requireLogin('mudur');

    $studentModel = new \App\Models\StudentModel();
    $siniflar = $studentModel->select('class')->distinct()->findAll();

    return view('mudur/dashboard', ['siniflar' => $siniflar]);
}


    public function kullaniciEkle()
{
    requireLogin('mudur');

    $studentModel = new \App\Models\StudentModel();

    // En son öğrenci numarası üzerine +1 ekleme kodu
    $lastStudent = $studentModel
        ->orderBy('id', 'DESC')
        ->first();

    if ($lastStudent && is_numeric($lastStudent['student_no'])) {
        $nextStudentNo = (int)$lastStudent['student_no'] + 1;
    } else {
        $nextStudentNo = 1;
    }

    return view('mudur/kullanici_ekle', ['nextStudentNo' => $nextStudentNo]);
}

public function kullaniciKaydet()
{
    requireLogin('mudur');
    $userModel = new UserModel();
    $studentModel = new StudentModel();
    $teacherModel = new TeacherModel();

    $data = [
        'username' => $this->request->getPost('username'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => $this->request->getPost('role')
    ];

   
    $userModel->insert($data);
    $userId = $userModel->getInsertID();

   
    if ($data['role'] == 'ogrenci') {
        $studentModel->insert([
            'user_id' => $userId,
            'name' => $this->request->getPost('name'),
            'student_no' => $this->request->getPost('student_no'),
            'class' => $this->request->getPost('class')
        ]);
    } elseif ($data['role'] == 'ogretmen') {
        $teacherModel->insert([
            'user_id' => $userId,
            'name' => $this->request->getPost('name'),
            'branch' => $this->request->getPost('branch')
        ]);
    }

    return redirect()->to('/mudur/dashboard')->with('success', 'Kullanıcı başarıyla eklendi.');
}

public function kullaniciListele()
{
    requireLogin('mudur');
    $userModel = new \App\Models\UserModel();
    $users = $userModel->findAll();

    return view('mudur/kullanici_listele', ['users' => $users]);
}

public function kullaniciSil($id)
{
    requireLogin('mudur');
    $userModel = new \App\Models\UserModel();

    if ($userModel->find($id)) {
        $userModel->delete($id);
        return redirect()->to('/mudur/kullanici-listele')->with('success', 'Kullanıcı silindi.');
    } else {
        return redirect()->to('/mudur/kullanici-listele')->with('error', 'Kullanıcı bulunamadı.');
    }
}

public function kullaniciDuzenle($id)
{
    requireLogin('mudur');
    $userModel = new \App\Models\UserModel();
    $studentModel = new \App\Models\StudentModel();
    $teacherModel = new \App\Models\TeacherModel();

    $user = $userModel->find($id);

    if (!$user) {
        return redirect()->to('/mudur/kullanici-listele')->with('error', 'Kullanıcı bulunamadı.');
    }

    $detay = null;
    if ($user['role'] == 'ogrenci') {
        $detay = $studentModel->where('user_id', $id)->first();
    } elseif ($user['role'] == 'ogretmen') {
        $detay = $teacherModel->where('user_id', $id)->first();
    }

    return view('mudur/kullanici_duzenle', [
        'user' => $user,
        'detay' => $detay
    ]);
}

public function kullaniciGuncelle($id)
{
    requireLogin('mudur');
    $userModel = new \App\Models\UserModel();
    $studentModel = new \App\Models\StudentModel();
    $teacherModel = new \App\Models\TeacherModel();

    $user = $userModel->find($id);
    if (!$user) {
        return redirect()->to('/mudur/kullanici-listele')->with('error', 'Kullanıcı bulunamadı.');
    }

    $updateData = [
        'username' => $this->request->getPost('username'),
    ];

    // şifre yazarsan günceller boş bırakırsan değişmez !!
    $newPassword = $this->request->getPost('password');
    if (!empty($newPassword)) {
        $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    $userModel->update($id, $updateData);

    if ($user['role'] == 'ogrenci') {
        $studentModel->where('user_id', $id)->set([
            'name' => $this->request->getPost('name'),
            'student_no' => $this->request->getPost('student_no'),
            'class' => $this->request->getPost('class')
        ])->update();
    } elseif ($user['role'] == 'ogretmen') {
        $teacherModel->where('user_id', $id)->set([
            'name' => $this->request->getPost('name'),
            'branch' => $this->request->getPost('branch')
        ])->update();
    }

    return redirect()->to('/mudur/kullanici-listele')->with('success', 'Kullanıcı güncellendi.');
}




public function sinifDetay($class)
{
    requireLogin('mudur');

    $studentModel = new \App\Models\StudentModel();
    $gradeModel = new \App\Models\GradeModel();
    $absenceModel = new \App\Models\AbsenceModel();

    $students = $studentModel->where('class', $class)->findAll();

    
    $data = [];
    foreach ($students as $ogrenci) {
        $grades = $gradeModel->where('student_id', $ogrenci['id'])->findAll();
        $absences = $absenceModel->where('student_id', $ogrenci['id'])->findAll();

        $data[] = [
            'ogrenci' => $ogrenci,
            'notlar' => $grades,
            'devamsizliklar' => $absences
        ];
    }

    return view('mudur/sinif_detay', [
        'class' => $class,
        'data' => $data
    ]);
}


public function notSilm($id)
{
    requireLogin('mudur');

    $gradeModel = new \App\Models\GradeModel();
    $grade = $gradeModel->find($id);

    if (!$grade) {
        return redirect()->back()->with('error', 'Not bulunamadı.');
    }

    $gradeModel->delete($id);
    return redirect()->back()->with('success', 'Not silindi.');
}

public function devamsizlikSilm($id)
{
    requireLogin('mudur');

    $absenceModel = new \App\Models\AbsenceModel();
    $absence = $absenceModel->find($id);

    if (!$absence) {
        return redirect()->back()->with('error', 'Devamsızlık bulunamadı.');
    }

    $absenceModel->delete($id);
    return redirect()->back()->with('success', 'Devamsızlık silindi.');
}

}
