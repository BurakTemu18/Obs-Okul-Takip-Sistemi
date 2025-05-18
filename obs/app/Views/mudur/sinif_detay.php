<!DOCTYPE html>
<html>
<head>
    <title><?= esc($class['class_name']) ?> Sınıfı</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-4">

    <h2><?= esc($class['class_name']) ?> Sınıfı - Öğrenci Listesi</h2>

    <?php if (empty($data)): ?>
        <div class="alert alert-info">Bu sınıfa henüz öğrenci eklenmemiş.</div>
    <?php else: ?>
        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Ad Soyad</th>
            <th>Öğrenci No</th>
           
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <tr>
    <td>
        <a class="btn btn-primary mt-3" href="<?= base_url('mudur/ogrenci/' . $row['ogrenci']['id']) ?>">
            <?= esc($row['ogrenci']['name']) ?>
        </a>
    </td>
    <td><?= esc($row['ogrenci']['student_no']) ?></td>
</tr>
                
 
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="alert alert-info">
    <strong>Sınıf Ortalaması:</strong>
    <?= $sinifOrt !== null ? number_format($sinifOrt, 2) : 'Yetersiz veri' ?>
    &nbsp; | &nbsp;
    <strong>Toplam Devamsızlık:</strong>
    <?= $toplamDevamsizlik ?>
</div>
    <?php endif; ?>

    <a href="<?= base_url('mudur/siniflar') ?>" class="btn btn-secondary mt-3">← Geri Dön</a>

</body>
</html>
