<!DOCTYPE html>
<html>
<head>
    <title><?= esc($class['class_name']) ?> Sınıfı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <th>1.Sınav</th>
            <th>2.Sınav</th>
            <th>Performans Notu</th>
            <th>Ortalama Not</th>
            <th>Devamsızlık Sayısı</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?= esc($row['ogrenci']['name']) ?></td>
                <td><?= esc($row['ogrenci']['student_no']) ?></td>
                <td><?= $row['exam1'] !== null ? $row['exam1'] : '—' ?></td>
                <td><?= $row['exam2'] !== null ? $row['exam2'] : '—' ?></td>
                <td><?= $row['performance'] !== null ? $row['performance'] : '—' ?></td>
                <td><?= $row['ortalama'] !== null ? number_format($row['ortalama'], 2) : '—' ?></td>
                <td><?= $row['devamsizlik'] ?></td>
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
