<!DOCTYPE html>
<html>
<head>
    <title>Müdür Paneli</title>

    <h3>Merhaba, <?= esc(session()->get('name')) ?>!</h3>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">

    <h1>Hoş Geldiniz,</h1>
    <p>Bu panelden öğretmen ve öğrenci ekleme Not ve Devamsızlık görüntüleme işlemleri yapabilirsiniz.</p>

    <h3 class="mt-4">Sınıflar</h3>
<ul class="list-group">
    <?php foreach ($siniflar as $s): ?>
        <li class="list-group-item">
            <a class="btn btn-danger mt-3" href="<?= base_url('mudur/sinif/' . urlencode($s['class'])) ?>">
                <?= esc($s['class']) ?> Sınıfı
            </a>
        </li>
    <?php endforeach; ?>
</ul>

    
    <a href="<?= base_url('mudur/kullanici-listele') ?>" class="btn btn-primary mt-3">Kullanıcıları Görüntüle</a>
    <a href="<?= base_url('mudur/kullanici-ekle') ?>" class="btn btn-primary mt-3">Kullanıcıları ekle</a>

    <br>
    <br>
    <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-3">Çıkış Yap</a>

</body>
</html>