<!DOCTYPE html>
<html>
<head>
    <title>Not Ekle</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Not Ekle - <?= esc($student['name']) ?></h2>

    <form action="<?= base_url('ogretmen/not-kaydet') ?>" method="post">
        <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

        <div class="mb-3">
            <label>Ders Adı</label>
            <select name="subject" class="form-control" required>
                <option value="Türkçe">Türkçe</option>
                <option value="Matematik">Matematik</option>
                <option value="Fizik">Fizik</option>
                <option value="Kimya">Kimya</option>
                <option value="Biyoloji">Biyoloji</option>
            </select>
        </div>

        <div class="mb-3">
            <label>1. Sınav</label>
            <input type="number" name="exam1" class="form-control" >
        </div>

        <div class="mb-3">
            <label>2. Sınav</label>
            <input type="number" name="exam2" class="form-control" >
        </div>

        <div class="mb-3">
            <label>Performans</label>
            <input type="number" name="performance" class="form-control" >
        </div>

        <button class="btn btn-success">Kaydet</button>
        <a href="<?= base_url('ogretmen/dashboard') ?>" class="btn btn-secondary">Geri Dön</a>
    </form>
</body>
</html>
