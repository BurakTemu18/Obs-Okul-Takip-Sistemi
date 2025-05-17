<!DOCTYPE html>
<html>
<head>
    <title>Devamsızlık Ekle</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Devamsızlık Ekle - <?= esc($student['name']) ?></h2>


        <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

    <form action="<?= base_url('ogretmen/devamsizlik-kaydet') ?>" method="post">
        <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

        <div class="mb-3">
            <label>Tarih:</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Devamsızlık Türü:</label>
            <select name="type" class="form-control" required>
                <option value="">Seçiniz</option>
                <option value="tam">Tam Gün</option>
                <option value="yarim">Yarım Gün</option>
                <option value="ozurlu">Özürlü</option>
            </select>
        </div>

        <button class="btn btn-success">Kaydet</button>
        <a href="<?= base_url('ogretmen/dashboard') ?>" class="btn btn-secondary">Geri Dön</a>
    </form>
</body>
</html>
