<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Düzenle</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Kullanıcı Düzenle</h2>
    <form action="<?= base_url('mudur/kullanici-guncelle/'.$user['id']) ?>" method="post">

        <div class="mb-3">
            <label>Kullanıcı Adı:</label>
            <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Yeni Şifre (boş bırakılırsa değişmez):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <?php if ($user['role'] == 'ogrenci'): ?>
            <div class="mb-3">
                <label>Ad Soyad:</label>
                <input type="text" name="name" class="form-control" value="<?= esc($detay['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Öğrenci No:</label>
                <input type="text" name="student_no" class="form-control" value="<?= esc($detay['student_no']) ?>">
            </div>
            <div class="mb-3">
                <label>Sınıf:</label>
                <select name="class_id" class="form-control" required>
    <option value="">Sınıf Seçiniz</option>
    <?php foreach ($classes as $c): ?>
        <option value="<?= $c['id'] ?>" <?= $detay['class_id'] == $c['id'] ? 'selected' : '' ?>>
            <?= esc($c['class_name']) ?>
        </option>
    <?php endforeach; ?>
</select>
            </div>
        <?php elseif ($user['role'] == 'ogretmen'): ?>
            <div class="mb-3">
                <label>Ad Soyad:</label>
                <input type="text" name="name" class="form-control" value="<?= esc($detay['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Branş:</label>
                <input type="text" name="branch" class="form-control" value="<?= esc($detay['branch']) ?>">
            </div>
        <?php endif; ?>

        <button class="btn btn-success">Güncelle</button>
        <a href="<?= base_url('mudur/kullanici-listele') ?>" class="btn btn-secondary">İptal</a>
    </form>
</body>
</html>