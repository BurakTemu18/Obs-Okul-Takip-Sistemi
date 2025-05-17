<!DOCTYPE html>
<html>
<head>
    <title>Öğrenci Paneli</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Merhaba, <?= esc($student['name']) ?>!</h2>

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
                        <td><?= esc($g['subject']) ?></td>
                        <td><?= esc($g['exam1']) ?></td>
                        <td><?= esc($g['exam2']) ?></td>
                        <td><?= esc($g['performance']) ?></td>
                        <td><?= number_format(($g['exam1'] + $g['exam2'] + $g['performance']) / 3, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h4 class="mt-4">Devamsızlıklar</h4>
    <?php if (empty($absences)): ?>
        <p>Henüz devamsızlık yok.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Tür</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($absences as $a): ?>
                    <tr>
                        <td><?= esc($a['date']) ?></td>
                        <td>
                            <?php
                            if ($a['type'] == 'tam') echo 'Tam Gün';
                            elseif ($a['type'] == 'yarim') echo 'Yarım Gün';
                            elseif ($a['type'] == 'ozurlu') echo 'Özürlü';
                            else echo $a['type'];
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-4">Çıkış Yap</a>
</body>
</html>