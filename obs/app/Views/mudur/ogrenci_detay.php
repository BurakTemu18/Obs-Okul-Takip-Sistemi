<!DOCTYPE html>
<html>
<head>
    <title><?= esc($ogrenci['name']) ?> - Detaylar</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-4">

    <h2><?= esc($ogrenci['name']) ?> (<?= esc($ogrenci['student_no']) ?>) - <?= esc($class['class_name']) ?></h2>

    <h4 class="mt-4">Notlar</h4>
    <?php if (empty($grades)): ?>
        <p>Henüz not girilmemiş.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ders</th>
                    <th>1. Sınav</th>
                    <th>2. Sınav</th>
                    <th>Performans</th>
                    <th>Ortalama</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $g): ?>
                    <tr>
                        <td><?= $g['subject'] ?></td>
                        <td><?= $g['exam1'] ?></td>
                        <td><?= $g['exam2'] ?></td>
                        <td><?= $g['performance'] ?></td>
                        <td><?= $g['average'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h4 class="mt-4">Devamsızlıklar</h4>
    <?php if (empty($devamsizliklar)): ?>
        <p>Henüz devamsızlık kaydı yok.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($devamsizliklar as $d): ?>
                    <tr>
                        <td><?= esc($d['date']) ?></td>
                        <td><?= esc($d['type']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="<?= base_url('mudur/sinif/' . $ogrenci['class_id']) ?>" class="btn btn-secondary mt-3">← Sınıfa Geri Dön</a>
</body>
</html>
