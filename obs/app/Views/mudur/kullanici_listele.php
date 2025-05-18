<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Listesi</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Kullanıcı Listesi</h2>

    <a href="<?= base_url('mudur/dashboard') ?>" class="btn btn-secondary">Panele Dön</a>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kullanıcı Adı</th>
            <th>Rol</th>
            <th>İsim</th>
            <th>Öğrenci No</th>
            <th>Sınıf</th>
            <th>Oluşturma zamanı</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['role']) ?></td>
                <td><?= esc($user['ad']) ?></td>
                <td><?= esc($user['student_no']) ?></td>
                <td><?= esc($user['class_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>
                <td>
                    <a href="<?= base_url('mudur/kullanici-duzenle/'.$user['id']) ?>" class="btn btn-sm btn-warning">Düzenle</a>
                    <a href="<?= base_url('mudur/kullanici-sil/'.$user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">Sil</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    
</body>
</html>