<!DOCTYPE html>
<html>
<head>
    <title>Sınıf Yönetimi</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-4">

    <h2>Sınıf Yönetimi</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/mudur/sinif-ekle') ?>" method="post" class="mb-3">
        <div class="input-group">
            <input type="text" name="class_name" class="form-control" placeholder="Yeni sınıf adı (örnek: 11-A)" required>
            <button class="btn btn-primary" type="submit">Ekle</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>İd</th>
                <th>Sınıf Adı</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($siniflar as $sinif): ?>
                <tr>
                    <td><?= $sinif['id'] ?></td>
                    <td>
                        <a class="btn btn-primary mt-3" href="<?= base_url('/mudur/sinif/' . $sinif['id']) ?>">
        <?= esc($sinif['class_name']) ?>
    </a>
                    </td>
                    <td>
                        <a href="<?= base_url('/mudur/sinif-sil/' . $sinif['id']) ?>" 
                           onclick="return confirm('Bu sınıf silinsin mi?')" 
                           class="btn btn-sm btn-danger">Sil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= base_url('mudur/dashboard') ?>" class="btn btn-secondary mt-3">Panele Dön</a>
</body>
</html>
