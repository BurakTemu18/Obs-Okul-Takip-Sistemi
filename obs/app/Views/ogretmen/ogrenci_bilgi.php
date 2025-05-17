<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="/obs/assets/still.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Bilgileri</title>
</head>
<body>
<h2><?= esc($ogrenci['name']) ?> - Öğrenci Bilgileri</h2>

<h4>Notlar</h4>
<?php if (empty($notlar)): ?>
    <p>Not yok.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ders</th>
                <th>1. Sınav</th>
                <th>2. Sınav</th>
                <th>Performans</th>
                <th>Ortalama</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notlar as $n): ?>
                <tr>
                    <td><?= esc($n['subject']) ?></td>
                    <td><?= esc($n['exam1']) ?></td>
                    <td><?= esc($n['exam2']) ?></td>
                    <td><?= esc($n['performance']) ?></td>
                    <?php
  $notlar = array_filter([
    $n['exam1'],
    $n['exam2'],
    $n['performance']
  ], fn($val) => is_numeric($val));

  $ortalama = count($notlar) > 0 ? array_sum($notlar) / count($notlar) : 0;
?>
<td><?= number_format($ortalama, 2) ?></td>
                    <td>
                        <a href="<?= base_url('ogretmen/not-sil/'.$n['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Not silinsin mi?')">Sil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<h4 class="mt-4">Devamsızlıklar</h4>

<?php if (empty($devamsizliklar)): ?>
    <p>Devamsızlık yok.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tarih</th>
                <th>Tür</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devamsizliklar as $d): ?>
                <tr>
                    <td><?= esc($d['date']) ?></td>
                    <td>
                        <?php
                            if ($d['type'] == 'tam') echo 'Tam Gün';
                            elseif ($d['type'] == 'yarim') echo 'Yarım Gün';
                            elseif ($d['type'] == 'ozurlu') echo 'Özürlü';
                            else echo esc($d['type']);
                        ?>
                    </td>
                    <td>
                        <a href="<?= base_url('ogretmen/devamsizlik-sil/'.$d['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Devamsızlık silinsin mi?')">Sil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<a href="<?= base_url('ogretmen/dashboard') ?>" class="btn btn-secondary mt-3">Geri Dön</a>
    
</body>
</html>