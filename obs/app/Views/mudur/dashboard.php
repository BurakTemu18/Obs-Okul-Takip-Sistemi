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

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sınıf Adı</th>
            <th>Öğrenci Sayısı</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($classes as $c): ?>
            <tr>
                <td><?= esc($c['class_name']) ?></td>
                <td><?= $c['ogrenci_sayisi'] ?></td>
                <td>
                    <a href="<?= base_url('mudur/sinif/' . $c['id']) ?>" class="btn btn-sm btn-info">
                        Detay
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


    
    <a href="<?= base_url('mudur/kullanici-listele') ?>" class="btn btn-primary mt-3">Kullanıcıları Görüntüle</a>
    <a href="<?= base_url('mudur/kullanici-ekle') ?>" class="btn btn-primary mt-3">Kullanıcıları ekle</a>
    <a href="<?= base_url('mudur/siniflar') ?>" class="btn btn-primary mt-3">Sınıf Yönetimi</a>

    <br>
    <br>
    <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-3">Çıkış Yap</a>

</body>
</html>