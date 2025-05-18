<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use App\Models\ClassModel;

class Mudur extends BaseController
{
    public function dashboard()
{
    requireLogin('mudur');

    $studentModel = new \App\Models\StudentModel();
    $classModel = new \App\Models\ClassModel();
    $classes = $classModel->findAll();

        // Her sınıfın öğrenci sayısını toplayalım
    foreach ($classes as &$sinif) {
        $sinif['ogrenci_sayisi'] = $studentModel
            ->where('class_id', $sinif['id'])
            ->countAllResults();
    }

    return view('mudur/dashboard', ['classes' => $classes]);
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

    $classModel = new \App\Models\ClassModel();
    $classes = $classModel->findAll();

    $role = $this->request->getPost('role') ?? 'ogrenci';

   return view('mudur/kullanici_ekle', [
    'nextStudentNo' => $nextStudentNo,
    'classes'       => $classes,
    'role'          => 'ogrenci' // veya post ile gelen rol
]);




}

public function kullaniciKaydet()
{
    requireLogin('mudur');

    $password = $this->request->getPost('password');

if (empty($password)) {
    return redirect()->back()->with('error', 'Şifre boş olamaz.');
}

    $username = $this->request->getPost('username');

if (empty($username)) {
    return redirect()->back()->with('error', 'Kullanıcı adı boş olamaz.');
}

    $name = $this->request->getPost('name');

if (empty($name)) {
    return redirect()->back()->with('error', 'Adı Soyadı boş olamaz.');
}

    $userModel = new UserModel();
    if ($userModel->where('username', $username)->first()) {
        return redirect()->back()->with('error', 'Bu kullanıcı adı zaten kullanılıyor.');
    }



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
            'class_id' => $this->request->getPost('class_id')
            
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
    $studentModel = new \App\Models\StudentModel();
    $teacherModel = new \App\Models\TeacherModel();
    $classModel = new \App\Models\ClassModel();

    $users = $userModel->findAll();

    foreach ($users as &$user) {
        if ($user['role'] == 'ogrenci') {
            $ogrenci = $studentModel->where('user_id', $user['id'])->first();
            $user['ad'] = $ogrenci['name'] ?? '—';
            $user['student_no'] = $ogrenci['student_no'] ?? '—';

            if (isset($ogrenci['class_id'])) {
                $sinif = $classModel->find($ogrenci['class_id']);
                $user['class_name'] = $sinif['class_name'] ?? '—';
            } else {
                $user['class_name'] = '—';
            }

        } elseif ($user['role'] == 'ogretmen') {
            $ogretmen = $teacherModel->where('user_id', $user['id'])->first();
            $user['ad'] = $ogretmen['name'] ?? '—';
            $user['student_no'] = '—';
            $user['class_name'] = '—';
        } else {
            $user['ad'] = '—';
            $user['student_no'] = '—';
            $user['class_name'] = '—';
        }
    }

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
    $classModel = new \App\Models\ClassModel();

    $user = $userModel->find($id);

    if (!$user) {
        return redirect()->to('/mudur/kullanici-listele')->with('error', 'Kullanıcı bulunamadı.');
    }

    $detay = null;

    if ($user['role'] == 'ogrenci') {
        $detay = $studentModel->where('user_id', $id)->first();
        $classes = $classModel->findAll(); // sınıfları çek
    } elseif ($user['role'] == 'ogretmen') {
        $detay = $teacherModel->where('user_id', $id)->first();
        $classes = []; // öğretmenler için gerek yok
    }

    return view('mudur/kullanici_duzenle', [
        'user' => $user,
        'detay' => $detay,
        'classes' => $classes
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
        'name'       => $this->request->getPost('name'),
        'student_no' => $this->request->getPost('student_no'),
        'class_id'   => $this->request->getPost('class_id')
    ])->update();
} elseif ($user['role'] == 'ogretmen') {
        $teacherModel->where('user_id', $id)->set([
            'name' => $this->request->getPost('name'),
            'branch' => $this->request->getPost('branch')
        ])->update();
    }

    return redirect()->to('/mudur/kullanici-listele')->with('success', 'Kullanıcı güncellendi.');
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

public function sinifListele()
{
    requireLogin('mudur');

    $classModel = new \App\Models\ClassModel();
    $siniflar = $classModel->findAll();

    return view('mudur/siniflar', ['siniflar' => $siniflar]);
}

public function sinifEkle()
{
    requireLogin('mudur');

    $classModel = new \App\Models\ClassModel();
    $classModel->insert([
        'class_name' => $this->request->getPost('class_name')
    ]);

    return redirect()->to('/mudur/siniflar')->with('success', 'Sınıf eklendi.');
}

public function sinifSil($id)
{
    requireLogin('mudur');

    $classModel = new \App\Models\ClassModel();
    $classModel->delete($id);

    return redirect()->to('/mudur/siniflar')->with('success', 'Sınıf silindi.');
}

public function sinifDetay($id)
{
    requireLogin('mudur');

    $classModel = new \App\Models\ClassModel();
    $studentModel = new \App\Models\StudentModel();
    $gradeModel = new \App\Models\GradeModel();
    $absenceModel = new \App\Models\AbsenceModel();

    $class = $classModel->find($id);

    if (!$class) {
        return redirect()->to('/mudur/siniflar')->with('error', 'Sınıf bulunamadı.');
    }

    $students = $studentModel->where('class_id', $id)->findAll();

    $data = [];
    $toplamNot = 0;
    $toplamDevamsizlik = 0;
    $sayac = 0;

 foreach ($students as $ogr) {
    $notlar = $gradeModel->where('student_id', $ogr['id'])->findAll();
    $devamsizliklar = $absenceModel->where('student_id', $ogr['id'])->findAll();

    $exam1s = array_column($notlar, 'exam1');
    $exam2s = array_column($notlar, 'exam2');
    $performanslar = array_column($notlar, 'performance');

    // Ortalama hesapla
    $tekilNotlar = array_filter([...$exam1s, ...$exam2s, ...$performanslar], fn($v) => is_numeric($v));
    $ortalama = count($tekilNotlar) ? array_sum($tekilNotlar) / count($tekilNotlar) : null;

    if ($ortalama !== null) {
        $toplamNot += $ortalama;
        $sayac++;
    }

    $devamsizlikSayisi = count($devamsizliklar);
    $toplamDevamsizlik += $devamsizlikSayisi;

    $data[] = [
        'ogrenci' => $ogr,
        'exam1' => count($exam1s) ? round(array_sum($exam1s) / count($exam1s), 2) : null,
        'exam2' => count($exam2s) ? round(array_sum($exam2s) / count($exam2s), 2) : null,
        'performance' => count($performanslar) ? round(array_sum($performanslar) / count($performanslar), 2) : null,
        'ortalama' => $ortalama,
        'devamsizlik' => $devamsizlikSayisi
    ];
}

    $sinifOrtalamasi = $sayac > 0 ? $toplamNot / $sayac : null;

    return view('mudur/sinif_detay', [
        'class' => $class,
        'data' => $data,
        'sinifOrt' => $sinifOrtalamasi,
        'toplamDevamsizlik' => $toplamDevamsizlik
    ]);
}

public function ogrenciDetay($id)
{
    requireLogin('mudur');

    $studentModel = new \App\Models\StudentModel();
    $gradeModel = new \App\Models\GradeModel();
    $absenceModel = new \App\Models\AbsenceModel();
    $classModel = new \App\Models\ClassModel();

    $ogrenci = $studentModel->find($id);

    if (!$ogrenci) {
        return redirect()->back()->with('error', 'Öğrenci bulunamadı.');
    }

    $grades = $gradeModel->where('student_id', $id)->findAll();
    $devamsizliklar = $absenceModel->where('student_id', $id)->findAll();

    $class = $classModel->find($ogrenci['class_id']);

    return view('mudur/ogrenci_detay', [
        'ogrenci' => $ogrenci,
        'grades' => $grades,
        'devamsizliklar' => $devamsizliklar,
        'class' => $class
    ]);
}

}
