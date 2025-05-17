<!DOCTYPE html>
<html>
<head>
    <title>Öğretmen Paneli</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Öğretmen Paneli</h2>
    <h3>Merhaba, <?= esc(session()->get('name')) ?>!</h3>
    <p>Öğrencilere not veya devamsızlık eklemek için tıklayın.</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ad Soyad</th>
                <th>Öğrenci No</th>
                <th>Sınıf</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= esc($student['name']) ?></td>
                    <td><?= esc($student['student_no']) ?></td>
                    <td><?= esc($student['class']) ?></td>
                    <td>
                        
                        <a href="<?= base_url('ogretmen/not-ekle/'.$student['id']) ?>" class="btn btn-sm btn-primary">Not Ekle</a>
                        <a href="<?= base_url('ogretmen/devamsizlik-ekle/'.$student['id']) ?>" class="btn btn-sm btn-secondary">Devamsızlık Ekle</a>
                        <a href="<?= base_url('ogretmen/ogrenci/' . $student['id']) ?>" class="btn btn-sm btn-info">Bilgileri Gör</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= base_url('ogretmen/gecmis') ?>" class="btn btn-danger">Geçmişi Gör</a>

    <a href="<?= base_url('logout') ?>" class="btn btn-danger">Çıkış Yap</a>
</body>
</html>