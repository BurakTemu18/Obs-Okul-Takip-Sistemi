<!DOCTYPE html>
<html>
<head>
<?php helper('url'); ?>
    <title>OBS Giriş</title>
    <link rel="stylesheet" type="text/css" href="/obs/assets/still.css">
</head>
<body class="container mt-5">

    <h2 class="mb-4">OBS Giriş Ekranı</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('login/auth') ?>" method="post">
        <div class="mb-3">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Şifre</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Giriş Yap</button>
    </form>

</body>
</html>
