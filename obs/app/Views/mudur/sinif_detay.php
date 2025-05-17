<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Listesi</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
<h2><?= esc($class) ?> Sınıfı Öğrenci Bilgileri</h2>  
<a href="<?= base_url('mudur/dashboard') ?>" class="btn btn-secondary mt-3">Anasayfaya Gön</a>
<br>
<br>
<br>


<?php foreach ($data as $item): ?>
    <div class="card mb-4">
        <div class="card-header">
            <strong><?= esc($item['ogrenci']['name']) ?></strong> - No: <?= esc($item['ogrenci']['student_no']) ?>
        </div>
        <div class="card-body">
            <h5>Notlar:</h5>
            <?php if (empty($item['notlar'])): ?>
                <p>Not girilmemiş.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($item['notlar'] as $n): ?>
                        <li>
                            <?= esc($n['subject']) ?>: <?= $n['exam1'] ?>/<?= $n['exam2'] ?>/<?= $n['performance'] ?> → Ortalama: <?= number_format(($n['exam1'] + $n['exam2'] + $n['performance']) / 3, 2) ?>
                            <a href="<?= base_url('mudur/not-silm/'.$n['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Not silinsin mi?')">Sil</a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <h5>Devamsızlıklar:</h5>
            <?php if (empty($item['devamsizliklar'])): ?>
                <p>Devamsızlık yok.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($item['devamsizliklar'] as $d): ?>
                        <li>
                            <?= $d['date'] ?> - <?= ucfirst($d['type']) ?>
                            <a href="<?= base_url('mudur/devamsizlik-silm/'.$d['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Devamsızlık silinsin mi?')">Sil</a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>


</body>
</html>